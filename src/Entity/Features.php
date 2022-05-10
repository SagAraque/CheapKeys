<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Features
 *
 * @ORM\Table(name="features")
 * @ORM\Entity
 */
class Features
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_feature", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFeature;

    /**
     * @var string
     *
     * @ORM\Column(name="game_desc", type="text", length=0, nullable=false)
     */
    private $gameDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="game_developer", type="string", length=100, nullable=false)
     */
    private $gameDeveloper;

    /**
     * @var string
     *
     * @ORM\Column(name="game_distributor", type="string", length=100, nullable=false)
     */
    private $gameDistributor;

    /**
     * @var int
     *
     * @ORM\Column(name="game_stock", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $gameStock = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="game_slug", type="text", length=65535, nullable=false)
     */
    private $gameSlug;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="game_date", type="date", nullable=false)
     */
    private $gameDate;

    /**
     * @var string
     *
     * @ORM\Column(name="game_state", type="string", length=0, nullable=false)
     */
    private $gameState;

    /**
     * @var string
     *
     * @ORM\Column(name="min_req", type="text", length=0, nullable=false)
     */
    private $minReq;

    /**
     * @var string
     *
     * @ORM\Column(name="max_req", type="text", length=0, nullable=false)
     */
    private $maxReq;

    /**
     * @var string
     *
     * @ORM\Column(name="game_price", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $gamePrice;

    /**
     * @var int
     *
     * @ORM\Column(name="game_discount", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $gameDiscount = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="game_valoration", type="decimal", precision=2, scale=1, nullable=false)
     */
    private $gameValoration;

    /**
     * @var int
     *
     * @ORM\Column(name="game_pegi", type="integer", nullable=false)
     */
    private $gamePegi;

    public function getIdFeature(): ?int
    {
        return $this->idFeature;
    }

    public function getGameDesc(): ?string
    {
        return $this->gameDesc;
    }

    public function setGameDesc(string $gameDesc): self
    {
        $this->gameDesc = $gameDesc;

        return $this;
    }

    public function getGameDeveloper(): ?string
    {
        return $this->gameDeveloper;
    }

    public function setGameDeveloper(string $gameDeveloper): self
    {
        $this->gameDeveloper = $gameDeveloper;

        return $this;
    }

    public function getGameDistributor(): ?string
    {
        return $this->gameDistributor;
    }

    public function setGameDistributor(string $gameDistributor): self
    {
        $this->gameDistributor = $gameDistributor;

        return $this;
    }

    public function getGameStock(): ?int
    {
        return $this->gameStock;
    }

    public function setGameStock(int $gameStock): self
    {
        $this->gameStock = $gameStock;

        return $this;
    }

    public function getGameSlug(): ?string
    {
        return $this->gameSlug;
    }

    public function setGameSlug(string $gameSlug): self
    {
        $this->gameSlug = $gameSlug;

        return $this;
    }

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->gameDate;
    }

    public function setGameDate(\DateTimeInterface $gameDate): self
    {
        $this->gameDate = $gameDate;

        return $this;
    }

    public function getGameState(): ?string
    {
        return $this->gameState;
    }

    public function setGameState(string $gameState): self
    {
        $this->gameState = $gameState;

        return $this;
    }

    public function getMinReq(): ?string
    {
        return $this->minReq;
    }

    public function setMinReq(string $minReq): self
    {
        $this->minReq = $minReq;

        return $this;
    }

    public function getMaxReq(): ?string
    {
        return $this->maxReq;
    }

    public function setMaxReq(string $maxReq): self
    {
        $this->maxReq = $maxReq;

        return $this;
    }

    public function getGamePrice(): ?string
    {
        return $this->gamePrice;
    }

    public function setGamePrice(string $gamePrice): self
    {
        $this->gamePrice = $gamePrice;

        return $this;
    }

    public function getGameDiscount(): ?int
    {
        return $this->gameDiscount;
    }

    public function setGameDiscount(int $gameDiscount): self
    {
        $this->gameDiscount = $gameDiscount;

        return $this;
    }

    public function getGameValoration(): ?string
    {
        return $this->gameValoration;
    }

    public function setGameValoration(string $gameValoration): self
    {
        $this->gameValoration = $gameValoration;

        return $this;
    }

    public function getGamePegi(): ?int
    {
        return $this->gamePegi;
    }

    public function setGamePegi(int $gamePegi): self
    {
        $this->gamePegi = $gamePegi;

        return $this;
    }


}
