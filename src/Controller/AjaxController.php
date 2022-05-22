<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use App\Utils\CartCount;
use App\Entity\Reviews;
use App\Entity\Users;
use App\Entity\Cart;
use App\Entity\CartProducts;
use App\Entity\Games;
use App\Entity\Platforms;
use App\Entity\Billing;
use App\Entity\GamesPlatform;
use App\Utils\Paginator;
use App\Entity\WishlistGames;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends AbstractController
{

    /**
     * @Route("/ajax/reviews")
     */
    public function reviews(ManagerRegistry $doctrine, Paginator $paginator, Request $request): Response
    {
        $params = $request->query;
        $reviews = $doctrine->getRepository(Reviews::class)->findByGameNoResults(array(
            "id_game" => $params->get('id'),
        ));

        $page = $params->getInt('page');
        $paginator->paginate($reviews, $page);

        return $this->render('ajax/reviews.html.twig',[
            'reviews' => $paginator
        ]);
    }

    /**
     * @Route("/ajax/wishlist")
     */
    public function wishlist(ManagerRegistry $doctrine, Request $request, Security $security)
    {
        $user = $security->getUser();
        
        if($user == null){
            return new Response("", 302);
        }

        $em = $doctrine->getManager();

        $gameId = $request->get('_game');
        $platformId = $request->get('_platform');

        $wishlist = $doctrine->getRepository(WishlistGames::class)->findGameByUser($gameId, $platformId, $user->getUserWishlist());

        if($wishlist == null){
            $game = $doctrine->getRepository(Games::class)->find($gameId);
    
            $platform = $doctrine->getRepository(Platforms::class)->find($platformId);
    
            $wishlist = new WishlistGames();
            $wishlist->setIdGame($game);
            $wishlist->setIdPlatform($platform);
            $wishlist->setIdWishlist($user->getUserWishlist());

            $em->persist($wishlist);
            $em->flush();

            return new Response("Added", 200);
        }else{
            $em->remove($wishlist);
            $em->flush();

            return new Response("Deleted", 200);
        }
    }


    /**
     * @Route("/ajax/deleteBilling")
     */
    public function deleteBilling(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $bd = $doctrine->getRepository(Billing::class)->find($request->get('id'));
        $bd->setBillingState('DELETED');

        $entityManager->persist($bd);
        $entityManager->flush();

        return new Response("", 200);
    }

    /**
     * @Route("/ajax/removeCartProduct")
     */
    public function removeCartProduct(ManagerRegistry $doctrine, Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $security->getUser();

        if($user == null) return new Response('', 302);

        $cart = $doctrine->getRepository((Cart::class))->findBy(array(
            'idUser' => $user->getIdUser(),
            'cartState' => 1
        ));

        if($cart == null) return new Response ('', 404);

        $game = $doctrine->getRepository(CartProducts::class)->findBy(array(
            'idGame' => $request->get('game'),
            'idPlatform' => $request->get('platform'),
            'idCart' => $cart[0]->getIdCart()
        ));

        if($game == null) return new Response ('', 404);

        $gamePlatform = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $request->get('game'),
            'idPlatform' => $request->get('platform'),
        ));

        $gamePrice = $gamePlatform[0]->getIdFeature()->getGamePrice();
        $discount = $gamePlatform[0]->getIdFeature()->getGameDiscount();
        $discount =  round($gamePrice - ($gamePrice * ($discount / 100)), 2);
        $gameTotal = $discount * $game[0]->getCant();
        $cartTotal = $cart[0]->getCartTotal();

        $cart[0]->setCartTotal($cartTotal - $gameTotal);
        $entityManager->persist($cart[0]);
        $entityManager->remove($game[0]);

        $entityManager->flush();

        $cartCount = new CartCount($doctrine, $security);
        $count = $cartCount->getCount();


        return new JsonResponse(array('cartTotal' => $count, 'totalPrice' => ($cartTotal - $gameTotal)));
    }

    /**
     * @Route("/ajax/addProductCart")
     */
    public function addProductCart(ManagerRegistry $doctrine, Request $request, Security $security, EntityManagerInterface $entityManager)
    {
        $user = $security->getUser();

        if($user == null){
            return new Response("", 302);
        }

        $game = $doctrine->getRepository(Games::class)->find($request->get('game'));
        $platform = $doctrine->getRepository(Platforms::class)->find($request->get('platform'));

        $cart = $doctrine->getRepository(Cart::class)->findBy(array(
            'idUser' => $user->getIdUser(),
            'cartState' => 1
        ));

        $productCart = $doctrine->getRepository(CartProducts::class)->findBy(array(
            'idCart' => $cart[0]->getIdCart(),
            'idGame' => $game->getIdGame(),
            'idPlatform' => $platform->getIdPlatform()
        ));

        $this->setProduct($cart[0], $game, $platform, $productCart, $entityManager, $doctrine);

        $count = intval($request->get('cartCount'));
        return new Response($count + 1, 200);

    }


    private function setProduct($cart, $game, $platform, $productCart, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        if($productCart == null){
            $newProduct = new CartProducts();
            
            $newProduct -> setIdCart($cart);
            $newProduct -> setIdGame($game);
            $newProduct -> setIdPlatform($platform);

            $entityManager->persist($newProduct);
            $entityManager->flush($newProduct);

        }else{
            $cant = $productCart[0]->getCant();
            $productCart[0]->setCant($cant + 1);

            $entityManager->persist($productCart[0]);
            $entityManager->flush($productCart[0]);
        }

        $gamePlatform = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'idPlatform' => $platform->getIdPlatform(),
            'game' => $game->getIdGame(),
        ));

        $price = $gamePlatform[0]->getIdFeature()->getGamePrice();
        $discount = $gamePlatform[0]->getIdFeature()->getGameDiscount();
        $total = $cart->getCartTotal();
        
        $priceDiscount = $price - ($price * ($discount / 100));

        $cart->setCartTotal($total + $priceDiscount);

        $entityManager->persist($cart);
        $entityManager->flush($cart);

    }
}
