<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WishlistGames
 *
 * @ORM\Table(name="wishlist_games", indexes={@ORM\Index(name="FK11", columns={"id_wishlist"}), @ORM\Index(name="FK13", columns={"id_platform"}), @ORM\Index(name="IDX_AB8643C9A80B2D8E", columns={"id_game"})})
 * @ORM\Entity
 */
class WishlistGames
{
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
     * @var \Wishlist
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Wishlist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_wishlist", referencedColumnName="id_wishlist")
     * })
     */
    private $idWishlist;

    public function getIdGame(): ?Games
    {
        return $this->idGame;
    }

    public function setIdGame(?Games $idGame): self
    {
        $this->idGame = $idGame;

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

    public function getIdWishlist(): ?Wishlist
    {
        return $this->idWishlist;
    }

    public function setIdWishlist(?Wishlist $idWishlist): self
    {
        $this->idWishlist = $idWishlist;

        return $this;
    }


}
