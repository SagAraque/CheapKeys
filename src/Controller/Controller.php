<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Utils\Paginator;
use App\Utils\CartCount;
use App\Entity\Games;
use App\Entity\Reviews;
use App\Entity\Features;
use App\Entity\Platforms;
use App\Entity\CartProducts;
use App\Entity\Cart;
use App\Entity\GamesPlatform;
use App\Entity\MediaGames;
use App\Entity\WishlistGames;

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
     * @Route("/cart", name="cart")
     */
    public function cart(ManagerRegistry $doctrine, Security $security):Response
    {
        $user = $this->getUser();

        $cartCount = new CartCount($doctrine, $security);
        $cartCant = $cartCount->getCount();

        $cart = $doctrine->getRepository(Cart::class)->findBy(array(
            'idUser' =>  $user->getIdUser(),
            'cartState' => 1
        ));

        $cartContent = $doctrine->getRepository(CartProducts::class)->findBy(array(
            'idCart' => $cart[0]->getIdCart()
        ));

        $gamesId = [];
        $platformsId = [];

        foreach ($cartContent as $game) {
            array_push($gamesId, strval($game->getIdGame()));
            array_push($platformsId, strval($game->getIdPlatform()));
        }

        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);
        $features = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $gamesId,
            'idPlatform' => $platformsId,
        ));
        
        return $this->render('/cart.html.twig', [
            'cartCant' => $cartCant,
            'cart' => $cart[0],
            'cartContent' => $cartContent,
            'images' => $images,
            'features' => $features,
        ]);
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
        
        $response = $this->render('/product.html.twig',[
            'game' => $game[0],
            'media' => $media,
            'medIaInfo' => $mediaInfo,
            'reviews' => $paginator,
            'features' => $features,
            'wish' => $wish,
            'cartCant' => $cart
        ]);

        // $response->setEtag(md5($response->getContent()));
        // $response->setPublic();
        // $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/store/{data}", requirements={"data"="pc|playstation|xbox|nintendo|ofertas|proximamente"}, name="category")
     */
    public function category($data, Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security):Response
    {

        $developer = $doctrine -> getRepository(Features::class) -> getDeveloper();
        $platforms = $doctrine -> getRepository(GamesPlatform::class) -> getPlatforms();
        $stock = $doctrine -> getRepository(Features::class) -> getStock();
        $pegi = $doctrine -> getRepository(Features::class) -> getPegi();
        $games = $doctrine -> getRepository(GamesPlatform::class) -> findAllNoQuery();

        $paginator->paginate($games, 1, 16);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $gamesId = [];
        $platformId = [];

        foreach ($paginator->getItems() as $game) {
            array_push($gamesId, strval($game->getGame()->getIdGame()));
            array_push($platformId, strval($game->getIdPlatform()->getIdPlatform()));
        }

        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformId);

        return $this->render('/store/store.html.twig',[
            'data' => $data,
            'developers' => $developer,
            'platforms' => $platforms,
            'stock' => $stock,
            'pegi' => $pegi,
            'paginator' => $paginator,
            'media' => $images,
            'cartCant' => $cart
        ]);
    }
}
