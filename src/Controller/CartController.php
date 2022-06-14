<?php

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\GamesPlatform;
use App\Entity\CartProducts;
use App\Entity\MediaGames;
use App\Entity\GameKeys;
use App\Utils\CartCount;
use App\Entity\Orders;
use App\Entity\Billing;
use App\Entity\Cart;
use App\Entity\Card;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function cart(ManagerRegistry $doctrine, Security $security, Request $request):Response
    {
        $user = $this->getUser();

        $cartCount = new CartCount($doctrine, $security);
        $cartCant = $cartCount->getCount();

        $cart = $doctrine->getRepository(Cart::class)->findBy(array(
            'idUser' =>  $user->getIdUser(),
            'cartState' => 1
        ));

        $cartContent = $doctrine->getRepository(CartProducts::class)->findBy(array(
            'idCart' => $cart[0]->getIdCart()
        ));

        $gamesId = [];
        $platformsId = [];

        foreach ($cartContent as $game) {
            array_push($gamesId, strval($game->getIdGame()));
            array_push($platformsId, strval($game->getIdPlatform()));
        }

        $images = $doctrine->getRepository(MediaGames::class)->findOnePerGame($gamesId, $platformsId);
        $features = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $gamesId,
            'idPlatform' => $platformsId
        ));

        $billing = $doctrine->getRepository(Billing::class)->findBy(array(
            'idUser' => $user->getIdUser(),
            'billingState' => 1
        ));

        $cards = $doctrine->getRepository(Card::class)->findBy(array(
            'cardUser' => $user->getIdUser(),
            'cardState' => 1
        ));
        
        $response = $this->render('/store/cart.html.twig', [
            'cartCant' => $cartCant,
            'cart' => $cart[0],
            'cartContent' => $cartContent,
            'images' => $images,
            'features' => $features,
            'billing' => $billing,
            'cards' => $cards
        ]);

        $response->setEtag(md5($response->getContent()));
        $response->setPrivate();
        $response->isNotModified($request);

        return $response;
    }

    /**
     * @Route("/cart/payment", name="payment")
     */
    public function payment(MailerInterface $mailer, ManagerRegistry $doctrine, Security $security, Request $request, EntityManagerInterface $entityManager): RedirectResponse
    {

        $token = $request -> request -> get('token');
        if(!($this->isCsrfTokenValid('comodore-amiga', $token))) throw new BadRequestHttpException('Maybe I´m not a tea pot', null, 403);

        $billId = $request->get('billingDirection');
        $cardId = $request->get('payMethod');
        $userId = $this->getUser()->getIdUser();

        // Check if billing direction id is correct
        $billingDirection = $doctrine->getRepository(Billing::class)->findBy(array(
            'idUser' => $userId,
            'idBilling' => $billId
        ));

        if($billingDirection == null)
        {
            $this->addFlash('error', 'Error en el pago');
            return $this->redirectToRoute('cart', [], 302);
        }

        // Check if pay method id is correct
        $userCard = $doctrine->getRepository(Card::class)->findBy(array(
            'cardUser' => $userId,
            'idCard' => $cardId,
            'cardState' => 1
        ));

        if($userCard == null)
        {
            $this->addFlash('error', 'Error en el pago');
            return $this->redirectToRoute('cart', [], 302);
        }


        // Get cart and cart products
        $cart = $doctrine->getRepository(Cart::class)->findBy(array(
            'idUser' => $userId,
            'cartState' => 1
        ));

        $cartProducts = $doctrine -> getRepository(CartProducts::class)->findBy(array('idCart' => $cart[0]->getIdCart())); 

        // Check if cart have products
        if($cartProducts == null)
        {
            $this->addFlash('error', 'El carrito no tiene productos');
            return $this->redirectToRoute('cart', [], 302);
        }

        $idGame = [];
        $idPlatform = [];

        foreach ($cartProducts as $product) {
            array_push($idGame, $product->getIdGame());
            array_push($idPlatform, $product->getIdPlatform());
        }

        $gamesPlatform = $doctrine->getRepository(GamesPlatform::class)->findBy(array(
            'game' => $idGame,
            'idPlatform' => $idPlatform
        ));


        // Check if cart products has stock
        if($this->checkStock($gamesPlatform, $cartProducts, $entityManager) == 0){
            $this->addFlash('error', 'Algunos productos se han quedado sin stock');
            return $this->redirectToRoute('cart', [], 302);
        }

        // Create a new order
        $order = new Orders();
        $order -> setIdUser($this->getUser());
        $order -> setOrderTotal($cart[0] -> getCartTotal());
        $order -> setOrderDate(new \DateTime());
        $order -> setIdBilling($billingDirection[0]);
        $order -> setIdCard($userCard[0]);
        $order -> setIdCart($cart[0]);

        //Getting games keys
        $index = 0;
        foreach ($cartProducts as $product) {
            // Update stock
            $feature = $gamesPlatform[$index]->getIdFeature();
            $feature -> setGameStock($feature -> getGameStock() - $product -> getCant());

            // Product cant = query limit
            $keys = $doctrine->getRepository(GameKeys::class)->findBy(array(
                'idPlatform' => $product->getIdPlatform(),
                'idGame' => $product->getIdGame(),
                'idOrder' => null
            ), null, $product->getCant());

            foreach ($keys as $gameKey) {
                $gameKey->setIdOrder($order);
                $entityManager -> persist($gameKey); 
            }
        }

        //Create a new cart
        $newCart = new Cart();
        $cart[0] -> setCartState(0);
        $newCart -> setIdUser($this->getuser());

        $entityManager -> persist($order);
        $entityManager -> persist($newCart);
        $entityManager -> persist($order);
        $entityManager -> flush();

        $email = (new TemplatedEmail())
            ->from('info@cheapkeys.com')
            ->to($this -> getUser() -> getUserEmail())
            ->subject('Registro completado')
            ->htmlTemplate('email.html.twig')
            ->context([
                'emailTitle' => 'Registro completado.',
                'emailContent' => 'Gracias por registrarte en CheapKeys, la web de compra de videojuegos de confianza.'
            ]);

        $mailer -> send($email);

        return $this->redirectToRoute('index', [], 302);
    }

    private function checkStock($games, $cartContent, EntityManagerInterface $em)
    {
        $index = 0 ;
        $stockCheck = 1;

        foreach ($games as $game) {
            $stock = $game->getIdFeature()->getGameStock();
            $cant = $cartContent[$index]->getCant();
            $price = $this->getDiscountPrice($game);
            $cart = $cartContent[$index]->getIdCart();
            $cartTotal = $cart->getCartTotal();

            if($stock < $cant){
                if($stock != 0){
                   $cartContent[$index]->setCant($stock);
                   $cart->setCartTotal($cartTotal - (($cant - $stock) * $price));
                   $em->persist($cartContent[$index]);
                   $em->persist($cart);
                }else{
                    $cart->setCartTotal($cartTotal - ($cant * $price));
                    $em->remove($cartContent[$index]);
                    $em->persist($cart);
                }
                $stockCheck = 0;
            }
            $index++;
        }

        if($stockCheck == 0) $em->flush();

        return $stockCheck;
        
    }

       /**
     * Return the game price with discount applied
     * @var $game 
     */
    private function getDiscountPrice($game)
    {
        $gamePrice = $game->getIdFeature()->getGamePrice();
        $gameDiscount = $game->getIdFeature()->getGameDiscount();
        $gameDiscount = $gameDiscount / 100;
        $gamePrice = round($gamePrice - ($gamePrice * $gameDiscount), 2);
        
        return $gamePrice;
    }
}
