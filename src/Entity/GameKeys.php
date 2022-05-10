<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameKeys
 *
 * @ORM\Table(name="game_keys", uniqueConstraints={@ORM\UniqueConstraint(name="key_value", columns={"key_value"})}, indexes={@ORM\Index(name="FK8", columns={"id_game"}), @ORM\Index(name="FK9", columns={"id_order"}), @ORM\Index(name="FK7", columns={"id_platform"})})
 * @ORM\Entity
 */
class GameKeys
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_key", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idKey;

    /**
     * @var string
     *
     * @ORM\Column(name="key_value", type="string", length=15, nullable=false)
     */
    private $keyValue;

    /**
     * @var \Platforms
     *
     * @ORM\ManyToOne(targetEntity="Platforms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_platform", referencedColumnName="id_platform")
     * })
     */
    private $idPlatform;

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_order", referencedColumnName="id_order")
     * })
     */
    private $idOrder;

    /**
     * @var \Games
     *
     * @ORM\ManyToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_game", referencedColumnName="id_game")
     * })
     */
    private $idGame;

    public function getIdKey(): ?int
    {
        return $this->idKey;
    }

    public function getKeyValue(): ?string
    {
        return $this->keyValue;
    }

    public function setKeyValue(string $keyValue): self
    {
        $this->keyValue = $keyValue;

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

    public function getIdOrder(): ?Orders
    {
        return $this->idOrder;
    }

    public function setIdOrder(?Orders $idOrder): self
    {
        $this->idOrder = $idOrder;

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
