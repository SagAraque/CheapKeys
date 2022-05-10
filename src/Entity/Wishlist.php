<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wishlist
 *
 * @ORM\Table(name="wishlist")
 * @ORM\Entity
 */
class Wishlist
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_wishlist", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idWishlist;

    public function getIdWishlist(): ?int
    {
        return $this->idWishlist;
    }


}
