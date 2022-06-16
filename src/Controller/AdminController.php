<?php

namespace App\Controller;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LoginType;
use App\Entity\GamesPlatform;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Orders;

class AdminController extends AbstractController
{
    /**
     * @Route("/administracion/login", name="admin_login")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $user = new Users();
        $loginForm = $this->createForm(LoginType::class, $user);

        $error = $authenticationUtils -> getLastAuthenticationError();


        $response = $this->render('admin/login.html.twig',[
            'error' => $error,
            'form' => $loginForm->createView(),
        ]);


        return $response;
    }

    /**
     * @Route("/administracion/dashboard", name="admin_dashboard")
     */
    public function dashboard(Request $request, ManagerRegistry $doctrine)
    {
        $nUsers = $doctrine -> getRepository(Users::class) -> getTotalUsers();
        $nGames = $doctrine -> getRepository(GamesPlatform::class) -> getTotalGames();
        $nOrders = $doctrine -> getRepository(Orders::class) -> getTotalOrders();
        $totalOrders = $doctrine -> getRepository(Orders::class) -> getTotalOrdersSum();

        $response = $this -> render('admin/dashboard.html.twig', [
            'nUsers' => $nUsers,
            'nGames' => $nGames,
            'nOrders' => $nOrders,
            'totalOrders' => $totalOrders
        ]);

        return $response;
    }
}
