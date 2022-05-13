<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\LoginType;
use App\Entity\Users;

class UserController extends AbstractController
{
    /**
     *  @Route("/users/login", name="user_login")
     */
    public function loginForm(AuthenticationUtils $auth): Response
    {

        $user = new User();
        $loginForm = $this->createForm(LoginType::class);

        $error = $auth -> getLastAuthenticationError();
        $lastUsername = $auth->getLastUsername();

        var_dump($form);
        return $this->render('users/login.html.twig',[
            'last_username' => $lastUsername,
            'error' => $error,
            'form' => $loginForm->createView()
        ]);
    }
    

    /**
     *  @Route("/users/control_panel", name="user_control_panel")
     */
    public function controlPanel(AuthenticationUtils $auth): Response
    {
        return $this->render('users/control_panel.html.twig');
    }
    
}
