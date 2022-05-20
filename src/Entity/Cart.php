<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table(name="cart", indexes={@ORM\Index(name="fk18", columns={"id_user"})})
 * @ORM\Entity
 */
class Cart
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_cart", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCart;

    /**
     * @var string
     *
     * @ORM\Column(name="cart_total", type="decimal", precision=5, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $cartTotal = '0.00';

    /**
     * @var bool
     *
     * @ORM\Column(name="cart_state", type="boolean", nullable=false, options={"default"="1"})
     */
    private $cartState = true;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdCart(): ?int
    {
        return $this->idCart;
    }

    public function getCartTotal(): ?string
    {
        return $this->cartTotal;
    }

    public function setCartTotal(string $cartTotal): self
    {
        $this->cartTotal = $cartTotal;

        return $this;
    }

    public function isCartState(): ?bool
    {
        return $this->cartState;
    }

    public function setCartState(bool $cartState): self
    {
        $this->cartState = $cartState;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
