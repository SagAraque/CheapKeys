<?php

namespace App\Controller;

use App\Entity\Games;
use App\Entity\Reviews;
use App\Utils\CartCount;
use App\Utils\Paginator;
use App\Entity\Platforms;
use App\Form\ContactType;
use App\Form\ReviewsType;
use App\Entity\MediaGames;
use App\Entity\GamesPlatform;
use App\Entity\WishlistGames;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Orders;

class Controller extends AbstractController
{
    /**
     *  @Route("/", name="index")
     */
    public function index(Request $request, ManagerRegistry $doctrine, Security $security): Response
    {
        $gameOffers = $doctrine -> getRepository(GamesPlatform::class)->findByDiscount();
        $bestsellers = $doctrine -> getRepository(GamesPlatform::class)->finddBestsellers();
        $reviews = $doctrine -> getRepository(Reviews::class)->findBy(array(),["reviewDate" => "DESC"], 4);


        $gamesId = [];
        $platformsId = [];

        foreach([$gameOffers, $bestsellers, $reviews] as $query)
        {
            foreach ($query as $game) {
                try {
                    array_push($gamesId, strval($game->getGame()->getIdGame()));
                } catch (\Throwable $th) {
                    array_push($gamesId, strval($game->getIdGame()->getIdGame()));
                }
                array_push($platformsId, strval($game->getIdPlatform()->getIdPlatform()));
            }
        }

        

        $media = $doctrine -> getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response = $this->render('/index.html.twig', [
            'cartCant' => $cart,
            'offers' => $gameOffers,
            'bestsellers' => $bestsellers,
            'reviews' => $reviews,
            'media' => $media
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/contacto", name="contact")
     */
    public function contact(Request $request,  ManagerRegistry $doctrine, Security $security ): Response
    {
        $contactForm = $this -> createForm(ContactType::class);

        $contactForm -> handleRequest($request);

        if($contactForm -> isSubmitted() && $contactForm -> isValid()){
            $contactForm = $this -> createForm(ContactType::class);
        }

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response =  $this->render('contact.html.twig', [
            "form" => $contactForm -> createView(),
            "cartCant" => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/sobre_nosotros", name="about_us")
     */
    public function aboutUs(Request $request, ManagerRegistry $doctrine, Security $security): Response
    {
        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response =  $this -> render('aboutUs.html.twig',[
            "cartCant" => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

        /**
     * @Route("/mapa_web", name="web_map")
     */
    public function webMap(Request $request, ManagerRegistry $doctrine, Security $security): Response
    {
        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response =  $this -> render('webmap.html.twig',[
            "cartCant" => $cart
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     *  @Route("/{game_slug}", name="product")
     */
    public function product($game_slug, EntityManagerInterface $entityManager, Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security):Response
    {
        $wish = false;
        $formError = false;
        $reviewForm = null;
        $platform = substr($game_slug, strripos($game_slug, '_') + 1);
        $gameSlug = substr($game_slug, 0, strripos($game_slug, '_'));
        
        $user = $security->getUser();

        // Get product data from data base
        $game = $doctrine->getRepository(Games::class)->findBy(array("gameSlug" => $gameSlug));
        $platform = $doctrine->getRepository(Platforms::class)->findByName(array('platform' => $platform));

        $features = $doctrine->getRepository(GamesPlatform::class)->findFeature($game[0], $platform);
        if($features == null) return $this -> redirectToRoute('index', [] ,302);


        if($user != null){
            $wishlist = $doctrine->getRepository(WishlistGames::class)->findGameByUser($game[0]->getIdGame(), $platform->getIdPlatform(), $user->getUserWishlist());
            $wish = $wishlist == null ? false : true;
        }

        // Get images from data base
        $media = $doctrine->getRepository(MediaGames::class)->findNoInfo(
            $game[0]->getIdGame(),
            $platform->getIdPlatform(),
        );

        $mediaInfo = $doctrine->getRepository(MediaGames::class)->findOneByInfo(
            $game[0]->getIdGame(),
            $platform->getIdPlatform(),
        );


        $reviews = $doctrine->getRepository(Reviews::class)->findByGameNoResults($game[0]->getIdGame(), $platform -> getIdPlatform());

        // Check if user has reviews of that product. In that case, reviews button and form are not printed
        $numReviews = $doctrine -> getRepository(Reviews::class) -> checkUserReview(
            $game[0] -> getIdGame(),
            $platform -> getIdPlatform(),
            $user == null ? null : $user -> getIdUser()
        );

        $numSolds = $doctrine -> getRepository(Orders::class) -> checkUserGamesSold(
            $game[0] -> getIdGame(),
            $platform -> getIdPlatform(),
            $user == null ? null : $user -> getIdUser()
        );

        if($numReviews == null && $numSolds != null){
            $newReview = new Reviews();
            $reviewForm = $this -> createForm(ReviewsType::class, $newReview);
            $reviewForm -> handleRequest($request);

            if($reviewForm -> isSubmitted() && !$reviewForm -> isValid()) $formError = true;
            
            $reviewForm = $reviewForm -> createView();
        }

        $paginator->paginate($reviews, 1);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $response = $this->render('/store/product.html.twig',[
            'game' => $game[0],
            'media' => $media,
            'medIaInfo' => $mediaInfo,
            'reviews' => $paginator,
            'features' => $features,
            'wish' => $wish,
            'cartCant' => $cart,
            'reviewForm' => $reviewForm,
            'formError' => $formError
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/store/{data}", requirements={"data"="pc|playstation|xbox|switch|ofertas|all"}, name="category")
     */
    public function category($data, Paginator $paginator, ManagerRegistry $doctrine, Request $request, Security $security):Response
    {
        $games = $doctrine -> getRepository(GamesPlatform::class) -> findAllNoQueryByPlatform($data);
        $countFilters = $games ->getQuery()->getResult();
        $platformFilter = 0;
        
        $paginator->paginate($games, 1, 12);

        $cartCount = new CartCount($doctrine, $security);
        $cart = $cartCount->getCount();

        $gamesId = [];
        $platformId = [];
        $devs = [];
        $platformsName = [];
        $pegi = [];
        $stock = ["En Stock" => 0, "Sin Stock" => 0];

        foreach ($countFilters as $game) {
            // Get games id
            array_push($gamesId, strval($game->getGame()->getIdGame()));
            // Get platforms id
            array_push($platformId, strval($game->getIdPlatform()->getIdPlatform()));
            // Gat game developers
            array_push($devs, $game->getIdFeature()->getGameDeveloper());
            // Get platform names
            array_push($platformsName, $game->getIdPlatform()->getPlatformName());
            // Get games pegi
            array_push($pegi, $game->getIdFeature()->getGamePegi());
            // Get games stock
            $gameStock = $game->getIdFeature()->getGamestock();
            $gameStock > 0 ? $stock['En Stock'] += 1 : $stock['Sin Stock'] += 1;
        }
        
        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformId);

        if($data == 'all'  || $data == 'pc') $platformFilter = 1;

        $response =  $this->render('/store/store.html.twig',[
            'data' => $data,
            'developers' => array_count_values($devs),
            'platforms' => array_count_values($platformsName),
            'stock' => $stock,
            'pegi' => array_count_values($pegi),
            'paginator' => $paginator,
            'media' => $images,
            'cartCant' => $cart,
            'platformFilter' => $platformFilter
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPublic();
        $response->isNotModified($request);
        
        return $response;
    }

    /**
     * @Route("/contact/checkform", methods={"POST"}, name="check_contact_form")
     */
    public function checkContactForm(MailerInterface $mailer, Request $request)
    {
        $contactForm = $this -> createForm(ContactType::class);
        $contactForm -> handleRequest($request);

        $token = $request -> request -> get('token');
        if($this->isCsrfTokenValid('IBM_MS-DOS', $token) && $contactForm -> isValid()){

            // Send email to user
            $email = (new TemplatedEmail())
            ->from('contact@cheapkeys.com')
            ->to('cheapkeys.store.info@gmail.com')
            ->subject('Contacto')
            ->htmlTemplate('emailContact.html.twig')
            ->context([
                'name' => $contactForm -> get('name') -> getData(),
                'emailEmail' => $contactForm -> get('email') -> getData(),
                'emailContent' => $contactForm -> get('message') -> getData()
            ]);

            $mailer -> send($email);

            $this->addFlash('success', 'Su mensaje ha sido enviado correctamente!');
            $request->overrideGlobals();
        }

        return $this->redirectToRoute('contact', [], 308);
    }

    /**
     * @Route ("/users/post_review", methods={"POST"}, name="post_review")
     */
    public function postReview(Request $request, Security $security, EntityManagerInterface $entityManager, ManagerRegistry $doctrine )
    {
        // Get game slug from last url
        $url = $request->headers->get('referer');
        $slug = substr($url, strripos($url, '/') + 1);
        $platformName = substr($slug, strripos($slug, '_') + 1);
        $gameSlug = substr($slug, 0, strripos($slug, '_'));

        // Getting game info
        $game = $doctrine -> getRepository(Games::class)->findBy(['gameSlug' => $gameSlug]);
        $platform = $doctrine -> getRepository(Platforms::class) -> findBy(['platformName' => $platformName]);

        $newReview = new Reviews();
        $newReview -> setIdUser($this -> getUser());
        $newReview -> setReviewDate(new \DateTime());
        $newReview -> setIdGame($game[0]);
        $newReview -> setIdPlatform($platform[0]);

        $reviewForm = $this -> createForm(ReviewsType::class, $newReview);
        $reviewForm -> handleRequest($request);

        if($reviewForm -> isValid()){
            $entityManager -> persist($newReview);
            
            $request -> overrideGlobals();

            $avg = $doctrine -> getRepository(Reviews::class) -> getAvgByGame($game[0] -> getIdGame(), $platform[0] -> getIdPlatform());

            $feature = $doctrine -> getRepository(GamesPlatform::class) -> findBy(array(
                'game' => $game[0] -> getIdGame(),
                'idPlatform' => $platform[0] -> getIdPlatform()
            ));
            
            $feature = $feature[0] -> getIdFeature();
            
            // If avg query result is null, that means game dont have reviews, so the new rating is the user´s rating
            $feature -> setGameValoration(
                $avg[0] == null ?  $newReview -> getReviewCalification()  : round($avg[0], 2, PHP_ROUND_HALF_ODD)
            );

            $entityManager -> persist($feature);
            $entityManager ->flush();
            $this->addFlash('success', 'Su review ha sido publicada!');
        }

        return $this->redirectToRoute('product', ['game_slug' => $slug, '_fragment' => 'reviews'], 308);
    }
}

