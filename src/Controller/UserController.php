<?php

namespace App\Controller;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\WishlistGames;
use App\Entity\MediaGames;
use App\Form\UserNameType;
use App\Form\UserPassType;
use App\Form\UserMailType;
use App\Form\CardType;
use App\Utils\CartCount;
use App\Entity\Billing;
use App\Entity\Card;

class UserController extends AbstractController
{
    /**
     *  @Route("/users/control_panel/mis_datos", name="user_control_panel_data")
     */
    public function controlPanelData(Request $request, Security $security, EntityManagerInterface $entityManager, ManagerRegistry $doctrine,UserPasswordHasherInterface $passwordEncoder): Response
    {
        $user = $this->getUser();
        $card = new Card();
        $card -> setCardUser($user);
        $cardClass = 'control__container--none';

        $lastUserName = $user->getUserName();

        $userNameForm = $this->createForm(UserNameType::class, $user);
        $userPassForm = $this->createForm(UserPassType::class, $user);
        $userMailForm = $this->createForm(UserMailType::class, $user);
        $userNewCard = $this->createForm(CardType::class, $card);

        $userNameForm -> handleRequest($request);
        $userPassForm -> handleRequest($request);
        $userMailForm -> handleRequest($request);
        $userNewCard -> handleRequest($request);

        if($userNameForm->isSubmitted() && $userNameForm->isValid() && $request->request->has('user_name')){
            $entityManager -> persist($user);
            $entityManager ->flush();
        }else{
            $user->setUserName($lastUserName);
        }

        if($userPassForm->isSubmitted() && $userPassForm->isValid() && $request->request->has('user_pass')){
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

        if($userMailForm->isSubmitted() && $userMailForm->isValid() && $request->request->has('user_mail')){
            $entityManager -> persist($user);
            $entityManager ->flush();
        }

        if($userNewCard->isSubmitted() && $userNewCard->isValid() && $request->request->has('card')){
            $entityManager -> persist($card);
            $entityManager ->flush();
            $card = new Card();
            $userNewCard = $this->createForm(CardType::class, $card);
        }else if($userNewCard->isSubmitted() && !($userNewCard->isValid() && $request->request->has('card'))){
            $cardClass = "";
        }

        $billing = $doctrine -> getRepository(Billing::class)->findBy(array(
            "idUser" => $user->getIdUser(),
            "billingState" => 'ACTIVE'
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
            'billings' => $billing,
            'cartCant' => $cart,
            'cards' => $cards,
            'class' => 'control__content--data',
            'cardClass' => $cardClass
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

        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('users/wishlist.html.twig',[
            'games' => $wishGames,
            'images' => $images,
            'cartCant' => $cart
        ]);
    }

    /**
     * @Route("/users/control_panel/addCard", name="add_card")
     */
    public function addCard(Request $request, Security $security, EntityManagerInterface $entityManager)
    {

    }
}
