<?php

namespace App\Utils;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use App\Entity\CartProducts;
use App\Entity\Cart;

class CartCount
{
    private $security;
    private $manager;

    function __construct(ManagerRegistry $doctrine, Security $security)
    {
        $this->security = $security;
        $this->manager = $doctrine;
    }

    function getCount()
    {
        $user = $this->security->getUser();
        $cant = 0;

        if($user != null){

            $cart = $this->manager->getRepository(Cart::class)->findBy(array(
                'idUser' => $user->getIdUser(),
                'cartState' => 1
            ));
    
            if($cart != null){
                $products = $this->manager->getRepository(CartProducts::class)->findBy(array(
                    'idCart' => $cart[0]->getIdCart()
                ));

                foreach ($products as $product) {
                    $cant = $cant + $product->getCant();
                }
            }
        }

        return $cant;
    }
}