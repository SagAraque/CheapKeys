<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Card
 *
 * @ORM\Table(name="card", indexes={@ORM\Index(name="FK28", columns={"card_user"})})
 * @ORM\Entity
 */
class Card
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_card", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCard;

    /**
     * @var string
     *
     * @ORM\Column(name="card_number", type="string", length=19, nullable=false)
     */
    private $cardNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="card_cvv", type="string", length=3, nullable=false)
     */
    private $cardCvv;

    /**
     * @var string
     *
     * @ORM\Column(name="card__expire", type="text", length=65535, nullable=false)
     */
    private $cardExpire;

    /**
     * @var string
     *
     * @ORM\Column(name="card_name", type="string", length=100, nullable=false)
     */
    private $cardName;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="card_state", type="boolean", nullable=true, options={"default"="1"})
     */
    private $cardState = true;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="card_user", referencedColumnName="id_user")
     * })
     */
    private $cardUser;

    public function getIdCard(): ?int
    {
        return $this->idCard;
    }

    public function getCardNumber(): ?string
    {
        return $this->cardNumber;
    }

    public function setCardNumber(string $cardNumber): self
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    public function getCardCvv(): ?string
    {
        return $this->cardCvv;
    }

    public function setCardCvv(string $cardCvv): self
    {
        $this->cardCvv = $cardCvv;

        return $this;
    }

    public function getCardExpire(): ?string
    {
        return $this->cardExpire;
    }

    public function setCardExpire(string $cardExpire): self
    {
        $this->cardExpire = $cardExpire;

        return $this;
    }

    public function getCardName(): ?string
    {
        return $this->cardName;
    }

    public function setCardName(string $cardName): self
    {
        $this->cardName = $cardName;

        return $this;
    }

    public function isCardState(): ?bool
    {
        return $this->cardState;
    }

    public function setCardState(?bool $cardState): self
    {
        $this->cardState = $cardState;

        return $this;
    }

    public function getCardUser(): ?Users
    {
        return $this->cardUser;
    }

    public function setCardUser(?Users $cardUser): self
    {
        $this->cardUser = $cardUser;

        return $this;
    }


}
