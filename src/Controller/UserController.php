<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Form\UserNameType;
use App\Form\UserPassType;
use App\Form\UserMailType;
use App\Entity\WishlistGames;
use App\Entity\Billing;
use App\Entity\MediaGames;
use App\Utils\CartCount;

class UserController extends AbstractController
{
    /**
     *  @Route("/users/control_panel/mis_datos", name="user_control_panel_data")
     */
    public function controlPanelData(Request $request, Security $security, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $lastUserName = $user->getUserName();

        $userNameForm = $this->createForm(UserNameType::class, $user);
        $userPassForm = $this->createForm(UserPassType::class, $user);
        $userMailForm = $this->createForm(UserMailType::class, $user);

        $userNameForm -> handleRequest($request);
        $userPassForm -> handleRequest($request);
        $userMailForm -> handleRequest($request);

        if($userNameForm->isSubmitted() && $userNameForm->isValid() && $request->request->has('user_name')){
            $entityManager -> persist($user);
            $entityManager ->flush();
        }else{
            $user->setUserName($lastUserName);
        }

        if($userPassForm->isSubmitted() && $userPassForm->isValid() && $request->request->has('user_pass')){
            $entityManager -> persist($user);
            $entityManager ->flush();
        }

        if($userMailForm->isSubmitted() && $userMailForm->isValid() && $request->request->has('user_mail')){
            $entityManager -> persist($user);
            $entityManager ->flush();
        }

        $billing = $doctrine -> getRepository(Billing::class)->findBy(array(
            "idUser" => $user->getIdUser(),
            "billingState" => 'ACTIVE'
        ));

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('forms/userDataForm.html.twig', [
            'userNameForm' => $userNameForm->createView(),
            'userPassForm' => $userPassForm->createView(),
            'userMailForm' => $userMailForm->createView(),
            'billings' => $billing,
            'cartCant' => $cart
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
}
