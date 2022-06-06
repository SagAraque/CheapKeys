<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartProducts
 *
 * @ORM\Table(name="cart_products", indexes={@ORM\Index(name="Fk21", columns={"id_platform"}), @ORM\Index(name="FK22", columns={"id_game"}), @ORM\Index(name="IDX_2D251531808394B5", columns={"id_cart"})})
 * @ORM\Entity
 */
class CartProducts
{
    /**
     * @var int
     *
     * @ORM\Column(name="cant", type="integer", nullable=false, options={"default"="1","unsigned"=true})
     */
    private $cant = 1;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", precision=5, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var \Cart
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cart", referencedColumnName="id_cart")
     * })
     */
    private $idCart;

    /**
     * @var \Platforms
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Platforms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_platform", referencedColumnName="id_platform")
     * })
     */
    private $idPlatform;

    /**
     * @var \Games
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_game", referencedColumnName="id_game")
     * })
     */
    private $idGame;

    public function getCant(): ?int
    {
        return $this->cant;
    }

    public function setCant(int $cant): self
    {
        $this->cant = $cant;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getIdCart(): ?Cart
    {
        return $this->idCart;
    }

    public function setIdCart(?Cart $idCart): self
    {
        $this->idCart = $idCart;

        return $this;
    }

    public function getIdPlatform(): ?Platforms
    {
        return $this->idPlatform;
    }

    public function setIdPlatform(?Platforms $idPlatform): self
    {
        $this->idPlatform = $idPlatform;

        return $this;
    }

    public function getIdGame(): ?Games
    {
        return $this->idGame;
    }

    public function setIdGame(?Games $idGame): self
    {
        $this->idGame = $idGame;

        return $this;
    }


}
