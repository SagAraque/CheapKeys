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
use App\Utils\Paginator;
use App\Entity\Card;
use App\Entity\Billing;

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
    public function dashboard(Request $request, ManagerRegistry $doctrine): Response
    {
        $nUsers = $doctrine -> getRepository(Users::class) -> getTotalUsers();
        $nGames = $doctrine -> getRepository(GamesPlatform::class) -> getTotalGames();
        $nOrders = $doctrine -> getRepository(Orders::class) -> getTotalOrders();
        $totalOrders = $doctrine -> getRepository(Orders::class) -> getTotalOrdersSum();
        $lastOrders = $doctrine -> getRepository(Orders::class) -> findBy([], null, 12);
        $noStock = $doctrine -> getRepository(GamesPlatform::class) -> getNoStock();

        $response = $this -> render('admin/dashboard.html.twig', [
            'nUsers' => $nUsers,
            'nGames' => $nGames,
            'nOrders' => $nOrders,
            'totalOrders' => $totalOrders,
            'lastOrders' => $lastOrders,
            'noStock' => $noStock,
            'button' => 'dashboard'
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/productos", name="admin_products")
     */
    public function adminProducts(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $products = $doctrine -> getRepository(GamesPlatform::class) -> getAllGamesNoQuery();

        $paginator -> paginate($products, 1, 8);

        $response = $this -> render('admin/products.html.twig', [
            'products' => $paginator,
            'button' => 'products'
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/getGames", name="get_games")
     */
    public function getGames(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $games = $doctrine -> getRepository(GamesPlatform::class) -> getAllGamesNoQuery();

        $paginator -> paginate($games, $request -> get('page'), 8);

        $response = $this -> render('ajax/adminProducts.html.twig', [
            'products' => $paginator,
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/pedidos", name="admin_orders")
     */
    public function adminOrders(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        
    }

    /**
     * @Route("/administracion/usuarios", name="admin_users")
     */
    public function adminUsers(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $users = $doctrine -> getRepository(Users::class) -> allUsersNoQuery();

        $paginator -> paginate($users, 1, 8);

        $response = $this -> render('admin/users.html.twig', [
            'users' => $paginator,
            'button' => 'users'
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/getUsers", name="get_users")
     */
    public function getUsers(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $users = $doctrine -> getRepository(Users::class) -> allUsersNoQuery();

        $paginator -> paginate($users, $request -> get('page'), 8);

        $response = $this -> render('ajax/adminUsers.html.twig', [
            'users' => $paginator,
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/user_data")
     */
    public function user_data(Request $request, ManagerRegistry $doctrine): Response
    {
        $id = $request -> get('id');
        $user = $doctrine -> getRepository(Users::class) -> findBy(array('idUser' => $id));
        $orders = $doctrine -> getRepository(Orders::class) -> findBy(array('idUser' => $id));
        $cards = $doctrine -> getRepository(Card::class) -> findBy(array('cardUser' => $id));
        $billing = $doctrine -> getRepository(Billing::class) -> findBy(array('idUser' => $id));

        $response = $this -> render('admin/ajax/usersData.html.twig', [
            'user' => $user[0],
            'orders' => $orders,
            'cards' => $cards,
            'billing' => $billing
        ]);

        return $response;
    }
}
