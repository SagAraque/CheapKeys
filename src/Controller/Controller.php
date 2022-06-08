<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Reviews;
use App\Utils\CartCount;
use App\Utils\Paginator;
use App\Entity\Platforms;
use App\Entity\MediaGames;
use App\Entity\GamesPlatform;
use App\Entity\WishlistGames;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Controller extends AbstractController
{
    /**
     *  @Route("/", name="index")
     */
    public function index(Request $request, ManagerRegistry $doctrine, Security $security): Response
    {
        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response = $this->render('/index.html.twig', [
            'cartCant' => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     *  @Route("/{game_slug}", name="product")
     */
    public function product($game_slug, Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security):Response
    {
        $wish = false;
        $platform = substr($game_slug, strripos($game_slug, '_') + 1);
        $gameSlug = substr($game_slug, 0, strripos($game_slug, '_'));
        
        $user = $security->getUser();

        $game = $doctrine->getRepository(Games::class)->findBy(array(
            "gameSlug" => $gameSlug
        ));

        $platform = $doctrine->getRepository(Platforms::class)->findByName(array(
            'platform' => $platform
        ));

        if($user != null){
            $wishlist = $doctrine->getRepository(WishlistGames::class)->findGameByUser($game[0]->getIdGame(), $platform->getIdPlatform(), $user->getUserWishlist());
            $wish = $wishlist == null ? false : true;
        }

        $media = $doctrine->getRepository(MediaGames::class)->findNoInfo(
            $game[0]->getIdGame(),
            $platform->getIdPlatform(),
        );

        $mediaInfo = $doctrine->getRepository(MediaGames::class)->findOneByInfo(
            $game[0]->getIdGame(),
            $platform->getIdPlatform(),
        );

        $features = $doctrine->getRepository(GamesPlatform::class)->findFeature($game[0], $platform);

        $reviews = $doctrine->getRepository(Reviews::class)->findByGameNoResults(array(
            "id_game" => $game[0]->getIdGame(),
        ));

        $paginator->paginate($reviews, 1);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response = $this->render('/store/product.html.twig',[
            'game' => $game[0],
            'media' => $media,
            'medIaInfo' => $mediaInfo,
            'reviews' => $paginator,
            'features' => $features,
            'wish' => $wish,
            'cartCant' => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/store/{data}", requirements={"data"="pc|playstation|xbox|switch|ofertas|all"}, name="category")
     */
    public function category($data, Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security):Response
    {
        $games = $doctrine -> getRepository(GamesPlatform::class) -> findAllNoQueryByPlatform($data);
        $platformFilter = 0;
        
        $paginator->paginate($games, 1, 8);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $gamesId = [];
        $platformId = [];
        $devs = [];
        $platformsName = [];
        $pegi = [];
        $stock = ["En Stock" => 0, "Sin Stock" => 0];

        foreach ($paginator->getItems() as $game) {
            // Get games id
            array_push($gamesId, strval($game->getGame()->getIdGame()));
            // Get platforms id
            array_push($platformId, strval($game->getIdPlatform()->getIdPlatform()));
            // Gat game developers
            array_push($devs, $game->getIdFeature()->getGameDeveloper());
            // Get platform names
            array_push($platformsName, $game->getIdPlatform()->getPlatformName());
            // Get games pegi
            array_push($pegi, $game->getIdFeature()->getGamePegi());
            // Get games stock
            $gameStock = $game->getIdFeature()->getGamestock();
            $gameStock > 0 ? $stock['En Stock'] += 1 : $stock['Sin Stock'] += 1;
        }
        
        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformId);

        if($data == 'all'  || $data == 'pc') $platformFilter = 1;

        $response =  $this->render('/store/store.html.twig',[
            'data' => $data,
            'developers' => array_count_values($devs),
            'platforms' => array_count_values($platformsName),
            'stock' => $stock,
            'pegi' => array_count_values($pegi),
            'paginator' => $paginator,
            'media' => $images,
            'cartCant' => $cart,
            'platformFilter' => $platformFilter
        ]);

        // $response->setEtag(md5($response->getContent()));
        // $response->setPublic();
        // $response->isNotModified($request);
        
        return $response;
    }
}

