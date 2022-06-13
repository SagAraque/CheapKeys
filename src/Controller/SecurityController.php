<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Users;
use App\Form\LoginType;
use App\Entity\Wishlist;
use App\Utils\CartCount;
use App\Form\RegisterFormType;
use App\Security\UsersAuthAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/users/login", name="user_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils,Security $security, ManagerRegistry $doctrine): Response
    {
        $user = new Users();
        $loginForm = $this->createForm(LoginType::class, $user);

        $error = $authenticationUtils -> getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response = $this->render('forms/userLoginForm.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $loginForm->createView(),
            'cartCant' => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPrivate();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/users/registro", name="app_register")
     */
    public function register(MailerInterface $mailer, UserPasswordHasherInterface $passwordHasher,Security $security, ManagerRegistry $doctrine, Request $request, UsersAuthAuthenticator $authenticator, UserAuthenticatorInterface $userAuthenticator , EntityManagerInterface $entityManager):Response
    {
        $user = new Users();
        $cart = new Cart();

        $registerForm = $this->createForm(RegisterFormType::class, $user);

        $registerForm -> handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $wishlist = new Wishlist();
            $entityManager -> persist($wishlist);

            $user->setUserEmail(strtolower($registerForm->get('userEmail')->getData()));
            $user->setUserName($registerForm->get('userName')->getData());

            $password = $registerForm->get('userPass')->getData();

            // Hash user password
            $hashedPassword = $passwordHasher->hashPassword($user, $password);

            $user->setPassword($hashedPassword);
            $user->setUserWishlist($wishlist);

            $cart->setIdUser($user);

            $entityManager -> persist($user);
            $entityManager -> persist($cart);

            $entityManager -> flush();


            // Send email to user
            $email = (new TemplatedEmail())
            ->from('info@cheapkeys.com')
            ->to($user -> getUserEmail())
            ->subject('Registro completado')
            ->htmlTemplate('email.html.twig')
            ->context([
                'emailTitle' => 'Registro completado.',
                'emailContent' => 'Gracias por registrarte en CheapKeys, la web de compra de videojuegos de confianza.'
            ]);

            $mailer -> send($email);

            // Authenticate user
            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response =  $this->render('forms/userRegisterForm.html.twig',[
            'form' => $registerForm->createView(),
            'cartCant' => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }


    /**
     * @Route("/users/login_check", name="app_check")
     */
    public function loginCheckAction()
    {

    }

    #[Route(path: '/users/logout', name: 'app_logout')]
    public function logout(): void
    {

    }
}
