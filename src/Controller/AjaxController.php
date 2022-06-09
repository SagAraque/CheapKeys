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
use App\Entity\MediaGames;
use App\Entity\Cart;
use App\Entity\Card;
use App\Entity\CartProducts;
use App\Entity\Games;
use App\Entity\Features;
use App\Entity\Orders;
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

        $response =  $this->render('ajax/reviews.html.twig',[
            'reviews' => $paginator
        ]);

        return new Response($response, 200);
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

        $gameId = $request->get('game');
        $platformId = $request->get('platform');

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
     * @Route("/ajax/delete_wishlist")
     */
    public function deleteWishlistGame(Request $request, ManagerRegistry $doctrine, Security $security, Paginator $paginator): Response
    {
        $user = $security->getUser();
        
        if($user == null) return new Response("", 302);
        

        $em = $doctrine->getManager();

        $gameId = $request->get('game');
        $platformId = $request->get('platform');
        $page = $request->get('page');

        $wishlist = $doctrine->getRepository(WishlistGames::class)->findGameByUser($gameId, $platformId, $user->getUserWishlist());

        if($wishlist == null) return new Response("", 404);

        $em->remove($wishlist);
        $em->flush();

        return $this->forward('App\Controller\AjaxController::wishlistGames');
    }

    /**
     * @Route("/ajax/wishlist_games")
     */
    public function wishlistGames(Request $request, ManagerRegistry $doctrine, Security $security, Paginator $paginator): Response
    {
        $page = $request->get('page');
        $wishGames = $doctrine->getRepository(GamesPlatform::class)->findAllWishNoQuery($this->getUser()->getUserWishlist());

        $paginator->paginate($wishGames, $page , 6);

        if($paginator->getLastPage() < $page ){
            $page = $paginator->getLastPage();
            $paginator->paginate($wishGames, $page , 6);
        }

        $gamesId = [];
        $platformsId = [];

        foreach ($paginator->getItems() as $game) {
            array_push($gamesId, strval($game->getGame()->getIdGame()));
            array_push($platformsId, strval($game->getIdPlatform()->getIdPlatform()));
        }
        
        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);

        return $this->render('ajax/wishCard.html.twig',[
            'paginator' => $paginator,
            'images' => $images,
            'actual' => $request->get('page')
        ]);
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

        $gamePrice = $this->getDiscountPrice($gamePlatform[0]);

        $gameTotal = $gamePrice * $game[0]->getCant();
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

        if($user == null) return new Response("", 302);
        
        $game = $doctrine->getRepository(Games::class)->find($request->get('game'));
        $platform = $doctrine->getRepository(Platforms::class)->find($request->get('platform'));
        $gamePlatform = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $request->get('game'),
            'idPlatform' => $request->get('platform'),
        ));

        if($gamePlatform[0]->getIdFeature()->getGameStock() == 0) return new Response('', 418);

        $cart = $doctrine->getRepository(Cart::class)->findBy(array(
            'idUser' => $user->getIdUser(),
            'cartState' => 1
        ));

        $productCart = $doctrine->getRepository(CartProducts::class)->findBy(array(
            'idCart' => $cart[0]->getIdCart(),
            'idGame' => $game->getIdGame(),
            'idPlatform' => $platform->getIdPlatform()
        ));

        $price = $this->getDiscountPrice($gamePlatform[0]);

        $this->setProduct($cart[0], $game, $platform, $productCart, $price, $entityManager, $doctrine);

        $count = intval($request->get('cartCount'));
        return new Response($count + 1, 200);

    }


    private function setProduct($cart, $game, $platform, $productCart, $price, EntityManagerInterface $entityManager, ManagerRegistry $doctrine)
    {
        if($productCart == null){
            $newProduct = new CartProducts();
            
            $newProduct -> setIdCart($cart);
            $newProduct -> setIdGame($game);
            $newProduct -> setIdPlatform($platform);
            $newProduct -> setPrice($price);

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
        $entityManager->flush();

    }

    /**
     * @Route("/ajax/changeCartCant", name="changeCartCant")
     */
    public function changeCartCant(ManagerRegistry $doctrine, Request $request, Security $security, EntityManagerInterface $entityManager): Response
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

        $gamePlatform = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $request->get('game'),
            'idPlatform' => $request->get('platform'),
        ));

        $gameCant = $game[0]->getCant();
        $changeValue = $request->get('changeValue');
        $newCant = $gameCant + $changeValue;

        if($newCant <= 0){
            $entityManager->remove($game[0]);
        }else{
            $game[0]->setCant($newCant);
            $entityManager->persist($game[0]);
        }

        $gamePrice = $this->getDiscountPrice($gamePlatform[0]);

        $cart[0]->setCartTotal($changeValue > 0 ? $cart[0]->getCartTotal() + $gamePrice : $cart[0]->getCartTotal() - $gamePrice);

        $entityManager->persist($cart[0]);

        $entityManager->flush();

        $cartCount = new CartCount($doctrine, $security);
        $count = $cartCount->getCount();

        return new JsonResponse(array('cartTotal' => $count, 'totalPrice' => $cart[0]->getCartTotal()));
    }

    /**
     * @Route("/ajax/changeStoreProducts", name="changeStoreProducts")
     */
    public function changeStoreProducts(Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $gameFeatures = $doctrine->getRepository(Features::class)->findMultipleFeatures(array(
            "gameDeveloper" => explode(',', $request->get("dev")),
            "gamePegi" => explode(',', $request->get("pegi")),
            ),
            explode(',', $request->get("stock")),
            $request->get('offers')
        );

        $features = [];
        foreach ($gameFeatures as $feature) {
            array_push($features, intval($feature['idFeature']));
        }

        $platforms = $doctrine->getRepository(Platforms::class)->findPlatformArrayId(
            explode(',', $request->get("platform")),
            $request->get("platformLimit")
        );

        $platformName = [];
        foreach ($platforms as $name) {
            array_push($platformName, intval($name['idPlatform']));
        }

        if(count($features) == 0) return new Response("No data", 404);

        $games = $doctrine->getRepository(GamesPlatform::class)->findByFeatureNoQuery(
            array(
                "idFeature" => $features, 
                "idPlatform" => $platformName
            ),
            $request->get('order')
        );

        $page = $request->get('page');
    
        $paginator->paginate($games, intval($page), 8);
        
        if($paginator->getTotal() == 0) return new Response("No data", 404);      

        $gamesId = [];
        $platformsId = [];
    
        foreach ($paginator->getItems() as $game) {
            array_push($gamesId, strval($game->getGame()->getIdGame()));
            array_push($platformsId, strval($game->getIdPlatform()->getIdPlatform()));
        }
    
        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);

            
        return $this->render('ajax/cardGame.html.twig',[
            'paginator' => $paginator,
            'media' => $images,
        ]);
    }

    /**
     * @Route("/ajax/searchBarResult", name="searchBarResult")
     */
    public function searchBarResult(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $param = $request ->query;

        if($param->get('string') == "") return new Response('', 404);

        $games = $doctrine->getRepository(GamesPLatform::class)->findByWord($param -> get('string'));
        $gamesId = [];
        $platformsId = [];
    
        foreach ($games as $game) {
            array_push($gamesId, strval($game->getGame()->getIdGame()));
            array_push($platformsId, strval($game->getIdPlatform()->getIdPlatform()));
        }

        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);
        
        return $this->render('ajax/searchCard.html.twig',[
            'games' => $games,
            'media' => $images
        ]);
    }

    /**
     * @Route("/ajax/deleteCard")
     */
    public function deleteCard(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $cardId = $request -> get('id');
        $user = $this->getUser();

        if($user == null) return new Response("", 403);
        
        $userCard = $doctrine -> getRepository(Card::class)->findBy(array(
            "idCard" => $cardId,
            "cardUser" => $user->getIdUser()
        ));

        if($userCard == null) return new Response("", 404);

        $userCard[0]->setCardState(0);
        $entityManager->persist($userCard[0]);
        $entityManager->flush();

        return new Response("", 200);
    }

    /**
     * @Route("/ajax/deleteBilling")
     */
    public function deleteBilling(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $billingId = $request -> get('id');
        $user = $this->getUser();

        if($user == null) return new Response("", 403);
        
        $userBilling = $doctrine -> getRepository(Billing::class)->findBy(array(
            "idBilling" => $billingId,
            "idUser" => $user->getIdUser()
        ));

        if($userBilling == null) return new Response("", 404);

        $userBilling[0]->setBillingState(0);
        $entityManager->persist($userBilling[0]);
        $entityManager->flush();

        return new Response("", 200);
    }

    /**
     * @Route("/ajax/set_user_image")
     */
    public function userImage(ManagerRegistry $doctrine, Request $request, EntityManagerInterface $entityManager): Response
    {
        $img = $request->files;
        return new Response(1, 200);
    }

    /**
     * @Route("/ajax/get_orders")
     */
    public function getOrders(Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if($user == null) return new Response('', 404);

        $orders = $doctrine->getRepository(Orders::class)->findAllByUser($user->getIdUser());
        $paginator -> paginate($orders, $request->get('page'), 2);

        $ordersId = [];
        $cartsId = [];
        foreach ($paginator->getItems() as $order) {
            array_push($ordersId, $order->getIdOrder());
            array_push($cartsId, $order->getIdCart()->getIdCart());
        }

        $cartProducts = $doctrine->getRepository(CartProducts::class)->findBy(array(
            'idCart' => $cartsId
        ));

        $gamesId = [];
        $platformsId = [];
        foreach ($cartProducts as $product) {
            array_push($gamesId, $product->getIdGame()->getIdGame());
            array_push($platformsId, $product->getIdPlatform()->getIdPlatform());
        }

        $media = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);

        return $this->render('ajax/ordersCard.html.twig',[
            'orders' => $paginator,
            'media' => $media,
            'products' => $cartProducts
        ]);
    }
    private function getDiscountPrice($game)
    {
        $gamePrice = $game->getIdFeature()->getGamePrice();
        $gameDiscount = $game->getIdFeature()->getGameDiscount();
        $gameDiscount = $gameDiscount / 100;
        $gamePrice = round($gamePrice - ($gamePrice * $gameDiscount), 2);
        
        return $gamePrice;
    }
}