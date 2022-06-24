<?php

namespace App\Controller;

use SplFileObject;
use App\Entity\Card;
use App\Entity\Games;
use App\Entity\Media;
use App\Entity\Users;
use App\Entity\Orders;
use App\Entity\Billing;
use App\Form\LoginType;
use App\Entity\Features;
use App\Entity\GameKeys;
use App\Utils\Paginator;
use App\Form\FeaturesType;
use App\Form\AdminUsersType;
use App\Entity\GamesPlatform;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Proxies\__CG__\App\Entity\MediaGames;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

        $idGame = null;
        $idPlatform = null;

        foreach ($paginator->getItems() as $firstGame) {
            $idGame = $firstGame -> getGame() -> getIdGame();   
            $idPlatform = $firstGame -> getIdPlatform() -> getIdPlatform();  
            break;
        }

        $gameData = $doctrine -> getRepository(GamesPlatform::class) -> findBy(array(
            'game' => $idGame,
            'idPlatform' => $idPlatform
        ));

        $keys = $doctrine -> getRepository(GameKeys::class) -> findBy(array(
            'idGame' => $idGame,
            'idPlatform' => $idPlatform
        ));

        $response = $this -> render('admin/products.html.twig', [
            'products' => $paginator,
            'button' => 'products',
            'game' => $gameData[0],
            'keys' => $keys
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

        $response = $this -> render('admin/ajax/adminProducts.html.twig', [
            'products' => $paginator,
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/product_data")
     */
    public function productData(Request $request, ManagerRegistry $doctrine): Response
    {
        $game = $doctrine -> getRepository(GamesPlatform::class) -> findBy(array(
            'game' => $request -> get('game'),
            'idPlatform' => $request -> get('platform')
        ));

        $keys = $doctrine -> getRepository(GameKeys::class) -> findBy(array(
            'idGame' => $request -> get('game'),
            'idPlatform' => $request -> get('platform')
        ));

        $response = $this -> render('admin/ajax/gameData.html.twig', [
            'game' => $game[0],
            'keys' => $keys
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/product_delete")
     */
    public function productDelete(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {

        $game = $doctrine -> getRepository(GamesPlatform::class) -> findBy(array(
            'game' => $request -> get('game'),
            'idPlatform' => $request -> get('platform')
        ));

        $game[0] -> setState(false);
        $entityManager -> persist($game[0]);
        $entityManager -> flush();

        return new Response('', 200);
    }

    /**
     * @Route("/administracion/upload_keys")
     */
    public function uploadKeys(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager, SerializerInterface $serializer): Response
    {
        $game = $doctrine -> getRepository(GamesPlatform::class) -> findBy(array(
            'game' => $request -> get('game'),
            'idPlatform' => $request -> get('platform')
        ));

        $file = $request->files->get('keys');
        $handle = fopen($file, 'r');

        if($handle){
            $count = 0;
            while (($value = fgets($handle, 4096)) !== false) {
                $key = new GameKeys();
                $key -> setKeyValue($value);
                $key -> setIdGame($game[0] -> getGame());
                $key -> setIdPlatform($game[0] -> getIdPlatform());

                $entityManager -> persist($key);
                $count++;
            }
            fclose($handle);

            $stock = $game[0] -> getIdFeature() -> getGameStock();
            $game[0] -> getIdFeature() -> setGameStock($stock + $count);

            $entityManager -> persist($game[0]);
            $entityManager -> flush();
        }

        $gameKeys = $doctrine -> getRepository(GameKeys::class) -> findBy(array(
            'idGame' => $request -> get('game'),
            'idPlatform' => $request -> get('platform')
        ));

        $jsonKeys = $serializer->serialize($gameKeys, JsonEncoder::FORMAT,[AbstractNormalizer::ATTRIBUTES =>[
            'idKey', 'keyValue', 'idOder' => ['idOrder']
        ]]);

        return new JsonResponse(json_decode($jsonKeys), 200, ['Content-Type' => 'application/json;charset=UTF-8']);
    }

    /**
     * @Route("/administracion/nuevo_producto", name="admin_add_product")
     */
    public function add_product(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $features = new Features();

        $gameForm = $this -> createForm(FeaturesType::class, $features);
        $gameForm -> handleRequest($request);

        if($gameForm -> isSubmitted() && $gameForm -> isValid()){
            $gameName = $gameForm ->get('gameName')->getData();
            $gameName = preg_replace('!\s+!', ' ', $gameName);
            $gameSlug = str_replace(" ", "_", $gameName);
            
            $features -> setMaxReq('{
                "OS": "Windows 7",
                "Procesador": "Intel Core i3-3210 3.2 GHz",
                "RAM": "2GB RAM",
                "Almacenamiento": "4GB",
                "Grafica": "Nvidia GeForce 400 Series"
              }');
            $features -> setMinReq('{
                "OS": "Windows 7",
                "Procesador": "Intel Core i3-3210 3.2 GHz",
                "RAM": "2GB RAM",
                "Almacenamiento": "4GB",
                "Grafica": "Nvidia GeForce 400 Series"
              }');

            $entityManager -> persist($features);

            $game = new Games();
            $game -> setGameName($gameName);
            $game -> setGameSlug(strtolower($gameSlug));

            $entityManager -> persist($game);

            $gamesPlatform = new GamesPlatform();

            $gamesPlatform -> setGame($game);
            $gamesPlatform -> setIdFeature($features);
            $gamesPlatform -> setIdPlatform($gameForm ->get('gamePlatform')->getData());

            $entityManager -> persist($gamesPlatform);

            $count = 1;
            $main = null;
            foreach ($request -> files as $fileArray) {
                foreach ($fileArray['gameImages'] as $file) {
                    $this -> convertImage(892, 496, $file, $gameSlug.''.$count);
                    $this -> convertImage(280, 157, $file, $gameSlug.''.$count, '-min');

                    $image = new Media();

                    $image -> setMediaUrl($gameSlug.''.$count);
                    $image -> setMediaAlt('Imagen del videojuego'.$game -> getGameName());
                    
                    if($file == $fileArray['gameMainImage']) {
                        $image -> setMediaPrincipal(true);
                        $main = 1;
                    }
                    
                    $imageGame = new MediaGames();

                    $imageGame -> setIdGame($game);
                    $imageGame -> setIdPlatform($gameForm ->get('gamePlatform')->getData());
                    $imageGame -> setIdMedia($image);

                    $entityManager -> persist($image);
                    $entityManager -> persist($imageGame);
                    $count++; 
                }
            }

            foreach ($request -> files as $fileArray) {
                $this -> convertImage(300, 169, $fileArray['gameInfoImage'], $gameSlug, '-info');
                
                $image = new Media();

                $image -> setMediaUrl($gameSlug.'-info');
                $image -> setMediaAlt('Imagen del videojuego'.$game -> getGameName());
                $image -> setMediaInfoimg(true);

                $imageGame = new MediaGames();

                $imageGame -> setIdGame($game);
                $imageGame -> setIdPlatform($gameForm ->get('gamePlatform')->getData());
                $imageGame -> setIdMedia($image);

                $entityManager -> persist($image);
                $entityManager -> persist($imageGame);
            }

            if($main != null)
            {
                foreach ($request -> files as $fileArray) {
                    $this -> convertImage(892, 496, $fileArray['gameMainImage'], $gameSlug.''.$count);
                    $this -> convertImage(280, 157, $fileArray['gameMainImage'], $gameSlug.''.$count, '-min');

                    $image = new Media();

                    $image -> setMediaUrl($gameSlug.''.$count);
                    $image -> setMediaAlt('Imagen del videojuego'.$game -> getGameName());
                    $image -> setMediaPrincipal(true);
                        
                    $imageGame = new MediaGames();

                    $imageGame -> setIdGame($game);
                    $imageGame -> setIdPlatform($gameForm ->get('gamePlatform')->getData());
                    $imageGame -> setIdMedia($image);

                    $entityManager -> persist($image);
                    $entityManager -> persist($imageGame);
                }
            }

            $entityManager -> flush();

            $features = new Features();
            $gameForm = $this -> createForm(FeaturesType::class, $features);
            
        }

        $response = $this -> render('admin/editForms/addProduct.html.twig',[
            'form' => $gameForm -> createView(),
            'button' => 'products'
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/modificar_producto", name="admin_modify_product")
     */
    public function modifyProduct(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $gamesPlatform = $doctrine -> getRepository(GamesPlatform::class) -> findBy(array(
            'game' => $request -> get('game'),
            'idPlatform' => $request -> get('platform')
        ));

        $gameForm = $this -> createForm(FeaturesType::class, $gamesPlatform[0] -> getIdFeature(), [
            'game' => $gamesPlatform[0] -> getGame() -> getGameName(),
            'images' => 0,
            'modify' => 1,
            'state' => $gamesPlatform[0] -> isState(),
            'platform' => $gamesPlatform[0] -> getIdPlatform()
        ]);

        $gameForm -> handleRequest($request);

        if($gameForm -> isSubmitted() && $gameForm -> isValid()){
            $gameName =  $gameForm ->get('gameName')->getData();
            $gamePlatform = $gameForm -> get('gamePlatform') -> getData();
            $gameState = $gameForm -> get('gameState') -> getData();
            $gameSlug = str_replace(" ", "_", preg_replace('!\s+!', ' ', $gameName));

            $gamesPlatform[0] -> getGame() -> setGameName($gameName);
            $gamesPlatform[0] -> getGame() -> setGameSlug($gameSlug);
            $gamesPlatform[0] -> setIdPlatform($gamePlatform);
            $gamesPlatform[0] -> setState($gameState);

            $entityManager -> persist($gamePlatform);
            $entityManager -> flush();

            $this->addFlash('success', 'Producto modificado correctamente!');
        }

        $response = $this -> render('admin/editForms/modifyProduct.html.twig',[
            'form' => $gameForm -> createView(),
            'button' => 'products'
        ]);
        
        return $response;
    }

    /**
     * @Route("/administracion/pedidos", name="admin_orders")
     */
    public function adminOrders(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $orders = $doctrine -> getRepository(Orders::class) -> allOrdersNoQuery();

        $paginator -> paginate($orders, 1,8);

        $order = null;
        foreach ($paginator -> getItems() as $firstOrder) {
            $order = $firstOrder;
        }

        
        $keys = $doctrine -> getRepository(GameKeys::class) -> findBy(array(
            'idOrder' => $order -> getIdOrder()
        ));

        $response = $this -> render('admin/orders.html.twig', [
            'orders' => $paginator,
            'order' => $order,
            'keys' => $keys,
            'button' => 'orders'
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/get_orders")
     */
    public function getOrder(Request $request, ManagerRegistry $doctrine): Response
    {
        $idOrder = $request -> get('order');
        $order = $doctrine -> getRepository(Orders::class) -> find($idOrder);
        $keys = $doctrine -> getRepository(GameKeys::class) -> findBy(array(
            'idOrder' => $idOrder
        ));

        $response = $this -> render('admin/ordersData.html.twig',[
            'order' => $order,
            'keys' => $keys
        ]);

        return $response;

    }

    /**
     * @Route("/administracion/usuarios", name="admin_users")
     */
    public function adminUsers(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $users = $doctrine -> getRepository(Users::class) -> allUsersNoQuery("");

        $paginator -> paginate($users, 1, 8);

        $id = null;

        foreach ($paginator->getItems() as $firstUser) {
            $id = $firstUser -> getIdUser();   
            break;
        }

        $user = $doctrine -> getRepository(Users::class) -> findBy(array('idUser' => $id));
        $orders = $doctrine -> getRepository(Orders::class) -> findBy(array('idUser' => $id));
        $cards = $doctrine -> getRepository(Card::class) -> findBy(array('cardUser' => $id));
        $billing = $doctrine -> getRepository(Billing::class) -> findBy(array('idUser' => $id));

        $response = $this -> render('admin/users.html.twig', [
            'users' => $paginator,
            'button' => 'users',
            'user' => $user[0],
            'orders' => $orders,
            'cards' => $cards,
            'billing' => $billing
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/getUsers", name="get_users")
     */
    public function getUsers(Request $request, ManagerRegistry $doctrine, Paginator $paginator): Response
    {
        $searchValue = $request -> get('search');
        $users = $doctrine -> getRepository(Users::class) -> allUsersNoQuery($searchValue);

        $paginator -> paginate($users, $request -> get('page'), 8);

        $response = $this -> render('admin/ajax/adminUsers.html.twig', [
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

    /**
     * @Route("/administracion/modify_user", name="modify_user")
     */
    public function modifyUser(Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $id = $request -> get('user');
        $user = $doctrine -> getRepository(Users::class) -> find($id);

        $userForm = $this -> createForm(AdminUsersType::class, $user);
        $userForm -> handleRequest($request);

        if($userForm -> isSubmitted() && $userForm -> isValid()){
            $password = $userForm['userPass'] -> getData();
            if($password != "" && $password != null){
                $hashedPassword = $passwordHasher->hashPassword($user, $password);
                $user -> setPassword($hashedPassword);
            }

            $entityManager -> persist($user);
            $entityManager -> flush($user);
            $this -> addFlash('success', 'El usuario ha sido modificado');
        }

        return $this -> render('admin/editForms/editUser.html.twig',[
            'adminUserForm' => $userForm -> createView(),
            'button' => 'users'
        ]);
    }

    /**
     * @Route("/administracion/user_delete")
     */
    public function deleteUser(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $entityManager): Response
    {
        $id = $request -> get('id');
        $user = $doctrine -> getRepository(Users::class) -> find($id);

        $user -> setUserState('DELETED');
        $entityManager -> persist($user);
        $entityManager -> flush();

        return new Response('', 200);
    }
    
    /**
     * @Route("/administracion/search_users")
     */
    public function searchUsers(Request $request , ManagerRegistry $doctrine, Paginator $paginator)
    {
        $searchValue = $request -> get('search');
        $users = $doctrine -> getRepository(Users::class) -> searchUsers($searchValue);

        $paginator -> paginate($users, 1, 8);

        $response = $this -> render('admin/ajax/adminUsers.html.twig', [
            'users' => $paginator,
        ]);

        return $response;
    }

    /**
     * @Route("/administracion/search_products")
     */
    public function searchProducts(Request $request , ManagerRegistry $doctrine, Paginator $paginator)
    {
        $searchValue = $request -> get('search');
        $products = $doctrine -> getRepository(GamesPlatform::class) -> searchProducts($searchValue);

        $paginator -> paginate($products, 1, 8);

        $response = $this -> render('admin/ajax/adminProducts.html.twig', [
            'products' => $paginator,
        ]);

        return $response;
    }

    private function convertImage($width, $height, $image, $newName, $extra = "")
    {
        $ext = $image -> getClientOriginalExtension();

        switch ($ext) {
            case 'jpg':
                $original = imagecreatefromjpeg($image);
                break;
            case 'jpeg':
                $original = imagecreatefromjpeg($image);
                break;
            case 'png':
                $original = imagecreatefromjpeg($image);
                break;
            case 'webp':
                $original = imagecreatefromjpeg($image);
                break;
        }

        $resized = imagecreatetruecolor($width, $height);

        list($oldWidth, $oldHeight) = getImagesize($image);
        imagecopyresampled($resized, $original, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight );

        imagewebp($resized,__DIR__."/../../public/static/img/games/{$newName}{$extra}.webp", 95);
    }
}

