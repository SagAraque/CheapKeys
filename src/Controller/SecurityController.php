<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\UsersAuthAuthenticator;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\LoginType;
use App\Form\RegisterFormType;
use App\Entity\Wishlist;
use App\Entity\Users;
use App\Utils\CartCount;

class SecurityController extends AbstractController
{

    /**
     * @Route("/users/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils,Security $security, ManagerRegistry $doctrine): Response
    {
        $user = new Users();
        $loginForm = $this->createForm(LoginType::class, $user);

        $error = $authenticationUtils -> getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('forms/userLoginForm.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $loginForm->createView(),
            'cartCant' => $cart
        ]);
    }

    /**
     * @Route("/users/registro", name="app_register")
     */
    public function register(UserPasswordHasherInterface $passwordHasher,Security $security, ManagerRegistry $doctrine, Request $request, UsersAuthAuthenticator $authenticator, UserAuthenticatorInterface $userAuthenticator , EntityManagerInterface $entityManager):Response
    {
        $user = new Users();
        $registerForm = $this->createForm(RegisterFormType::class, $user);

        $registerForm -> handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $wishlist = new Wishlist();
            $entityManager -> persist($wishlist);

            $user->setUserEmail($registerForm->get('userEmail')->getData());
            $user->setUserName($registerForm->get('userName')->getData());

            $password = $registerForm->get('userPass')->getData();

            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $password
            );

            $user->setPassword($hashedPassword);

            $user->setUserWishlist($wishlist);

            $entityManager -> persist($user);

            $entityManager -> flush();

            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        return $this->render('forms/userRegisterForm.html.twig',[
            'form' => $registerForm->createView(),
            'cartCant' => $cart
        ]);
    }


    /**
     * @Route("/users/login_check", name="app_check")
     */
    public function loginCheckAction()
    {
        // el "login check" lo hace Symfony automáticamente
    }

    #[Route(path: '/users/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
