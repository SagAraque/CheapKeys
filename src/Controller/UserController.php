<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Users;

class UserController extends AbstractController
{
    /**
     *  @Route("/users/login", name="user_login")
     */
    public function loginForm(AuthenticationUtils $auth): Response
    {
        $error = $auth -> getLastAuthenticationError();
        $lastUsername = $auth->getLastUsername();


        return $this->render('users/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }
    
}
