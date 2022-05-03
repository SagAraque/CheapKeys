<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameKeys
 *
 * @ORM\Table(name="game_keys", uniqueConstraints={@ORM\UniqueConstraint(name="unique_key", columns={"key_value"})}, indexes={@ORM\Index(name="fk_id_order_key", columns={"Id_order"}), @ORM\Index(name="fk_id_game_key", columns={"Id_game"})})
 * @ORM\Entity
 */
class GameKeys
{
    /**
     * @var int
     *
     * @ORM\Column(name="key_id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $keyId;

    /**
     * @var string
     *
     * @ORM\Column(name="key_value", type="string", length=15, nullable=false)
     */
    private $keyValue;

    /**
     * @var string
     *
     * @ORM\Column(name="Platform", type="string", length=0, nullable=false)
     */
    private $platform;

    /**
     * @var \Games
     *
     * @ORM\ManyToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_game", referencedColumnName="id_game")
     * })
     */
    private $idGame;

    /**
     * @var \Orders
     *
     * @ORM\ManyToOne(targetEntity="Orders")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="Id_order", referencedColumnName="id_order")
     * })
     */
    private $idOrder;

    public function getKeyId(): ?int
    {
        return $this->keyId;
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

    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    public function setPlatform(string $platform): self
    {
        $this->platform = $platform;

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

    public function getIdOrder(): ?Orders
    {
        return $this->idOrder;
    }

    public function setIdOrder(?Orders $idOrder): self
    {
        $this->idOrder = $idOrder;

        return $this;
    }


}
