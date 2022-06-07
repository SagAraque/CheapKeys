<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\UsersAuthAuthenticator;
use App\Form\BillingDirectionType;
use App\Entity\WishlistGames;
use App\Entity\GamesPlatform;
use App\Entity\CartProducts;
use App\Entity\MediaGames;
use App\Form\UserNameType;
use App\Form\UserPassType;
use App\Form\UserMailType;
use App\Utils\Paginator;
use App\Utils\CartCount;
use App\Entity\Billing;
use App\Form\CardType;
use App\Entity\Orders;
use App\Entity\Card;

class UserController extends AbstractController
{

    /**
     *  @Route("/users/control_panel/mis_datos", name="user_control_panel_data")
     */
    public function controlPanelData(Request $request, Security $security, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $card = new Card();
        $billingDirection = new Billing();
        $card -> setCardUser($user);
        $billingDirection->setIdUser($user);

        $userNameForm = $this->createForm(UserNameType::class, $user);
        $userPassForm = $this->createForm(UserPassType::class, $user);
        $userMailForm = $this->createForm(UserMailType::class, $user);
        $userNewCard = $this->createForm(CardType::class, $card);
        $userNewBillingDirection = $this->createForm(BillingDirectionType::class, $billingDirection);

        $userNameForm -> handleRequest($request);
        $userPassForm -> handleRequest($request);
        $userMailForm -> handleRequest($request);
        $userNewCard -> handleRequest($request);
        $userNewBillingDirection -> handleRequest($request);

        $billing = $doctrine -> getRepository(Billing::class)->findBy(array(
            "idUser" => $user->getIdUser(),
            "billingState" => 1
        ));

        $cards = $doctrine -> getRepository(Card::class)->findBy(array(
            "cardUser" => $user->getIdUser(),
            "cardState" => 1
        ));

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('users/user_data.html.twig', [
            'userNameForm' => $userNameForm->createView(),
            'userPassForm' => $userPassForm->createView(),
            'userMailForm' => $userMailForm->createView(),
            'userNewCard' => $userNewCard->createView(),
            'userNewBilling' => $userNewBillingDirection->createView(),
            'billings' => $billing,
            'cartCant' => $cart,
            'cards' => $cards,
            'class' => 'control__content--data',
            'menu' => 'data'
           ]);
    }


    /**
     * @Route("/users/control_panel/wishlist", name="user_control_panel_wish")
     */
    public function controlPanelWish(Request $request, ManagerRegistry $doctrine, Security $security): Response
    {

        $wishGames = $doctrine->getRepository(WishlistGames::class)->findByGamesWishlist(array(
            'idWishlist' => $this->getUser()->getUserWishlist()
        ));

        $gamesId = [];
        $platformsId = [];

        foreach ($wishGames as $game) {
            array_push($gamesId, strval($game->getIdGame()));
            array_push($platformsId, strval($game->getIdPlatform()));
        }

        $games = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $gamesId,
            'idPlatform' => $platformsId
        ));

        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('users/wishlist.html.twig',[
            'games' => $games,
            'images' => $images,
            'cartCant' => $cart,
            'class' => 'control__content--wishlist',
            'menu' => 'wishlist',
            'total' => count($wishGames)
        ]);
    }

    /**
     * @Route("/users/control_panel/orders", name="orders")
     */
    public function orders(Request $request, Security $security, ManagerRegistry $doctrine, Paginator $paginator)
    {
        $user = $this->getUser();

        $orders = $doctrine->getRepository(Orders::class)->findAllByUser($user->getIdUser());
        $paginator -> paginate($orders, 1, 10);

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
        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('users/orders.html.twig',[
            'class' => 'control__content--orders',
            'menu' => 'orders',
            'cartCant' => $cart,
            'orders' => $paginator,
            'media' => $media,
            'products' => $cartProducts
        ]);

    }

    /**
     * @Route("/users/control_panel/change_name", name="change_username")
     */
    public function changeUsername(Request $request, Security $security, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $lastUserName = $user->getUserName();
        $userNameForm = $this->createForm(UserNameType::class, $user);
        $userNameForm -> handleRequest($request);

        if($userNameForm->isValid() ){
            $entityManager -> persist($user);
            $entityManager ->flush();

            $request -> getSession()-> migrate(true);
        }else{
            $user->setUserName($lastUserName);
        }

        return $this->redirectToRoute('user_control_panel_data', [], 308);
    }

    /**
     * @Route("/users/control_panel/change_email", name="change_email")
     */
    public function changeEmail(Request $request, UserAuthenticatorInterface $userAuthenticator, UsersAuthAuthenticator $authenticator, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $lastEmail = $user->getUserEmail();
        $userMailForm = $this->createForm(UserMailType::class, $user);
        $userMailForm -> handleRequest($request);

        if($userMailForm->isValid()){
            $entityManager -> persist($user);
            $entityManager ->flush();

            $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );

            $request -> getSession()-> migrate(true);
        }else{
            $user->setUserEmail($lastEmail);
        }

        return $this->redirectToRoute('user_control_panel_data', [], 308);
    }

    /**
     * @Route("/users/control_panel/change_pass", name="change_pass")
     */
    public function changePassword(Request $request, Security $security, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordEncoder) : Response
    {
        $user = $this->getUser();
        $userPassForm = $this->createForm(UserPassType::class, $user);
        $userPassForm -> handleRequest($request);

        if($userPassForm->isValid()){
            if($passwordEncoder->isPasswordValid($user, $userPassForm->get('password')->getData())){
                $newPassword = $passwordEncoder->hashPassword($user, $userPassForm->get('newPass')->getData());
                $user -> setUserPass($newPassword);
                $entityManager -> persist($user);
                $entityManager ->flush();
                $request -> getSession()-> migrate(true);
            }else{
                $this->addFlash('error', 'La contraseña es incorrecta');
            }  
        }
        return $this->redirectToRoute('user_control_panel_data', [], 308);
    }

    /**
     * @Route("/users/control_panel/add_card", name="add_card")
     */
    public function addCard(Request $request, EntityManagerInterface  $entityManager): Response 
    {
        $user = $this->getUser();
        $card = new Card();

        $userNewCard = $this->createForm(CardType::class, $card);
        $userNewCard -> handleRequest($request);

        if($userNewCard->isValid()){
            $entityManager -> persist($card);
            $entityManager ->flush();
            $card = new Card();
            $userNewCard = $this->createForm(CardType::class, $card);
            $request->overrideGlobals();
        }

        return $this->redirectToRoute('user_control_panel_data', [], 308);
    }

    /**
     * @Route("/users/control_panel/add_billing_direction", name="add_billing_direction")
     */
    public function addBillingDirection(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $billingDirection = new Billing();
        $billingDirection->setIdUser($user);

        $userNewBillingDirection = $this->createForm(BillingDirectionType::class, $billingDirection);
        $userNewBillingDirection->handleRequest($request);

        if($userNewBillingDirection->isValid()){
             $entityManager -> persist($billingDirection);
             $entityManager ->flush();
             $request->overrideGlobals();
         }

         return $this->redirectToRoute('user_control_panel_data', [], 308);
    }
}

