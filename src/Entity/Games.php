<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Games
 *
 * @ORM\Table(name="games")
 * @ORM\Entity
 */
class Games
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_game", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGame;

    /**
     * @var string
     *
     * @ORM\Column(name="game_name", type="string", length=250, nullable=false)
     */
    private $gameName;

    /**
     * @var string
     *
     * @ORM\Column(name="game_desc", type="text", length=65535, nullable=false)
     */
    private $gameDesc;

    /**
     * @var string
     *
     * @ORM\Column(name="game_price", type="decimal", precision=5, scale=2, nullable=false)
     */
    private $gamePrice;

    /**
     * @var int
     *
     * @ORM\Column(name="game_discount", type="integer", nullable=false)
     */
    private $gameDiscount;

    /**
     * @var string
     *
     * @ORM\Column(name="game_plataform", type="string", length=150, nullable=false)
     */
    private $gamePlataform;

    /**
     * @var string
     *
     * @ORM\Column(name="game_developer", type="string", length=50, nullable=false)
     */
    private $gameDeveloper;

    /**
     * @var string
     *
     * @ORM\Column(name="game_distributor", type="string", length=50, nullable=false)
     */
    private $gameDistributor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="game_date", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $gameDate = 'current_timestamp()';

    /**
     * @var int
     *
     * @ORM\Column(name="game_pegi", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $gamePegi;

    /**
     * @var string
     *
     * @ORM\Column(name="game_valoration", type="decimal", precision=3, scale=1, nullable=false, options={"default"="0.0"})
     */
    private $gameValoration = '0.0';

    /**
     * @var int
     *
     * @ORM\Column(name="game_stock", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $gameStock = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="game_state", type="string", length=0, nullable=false)
     */
    private $gameState;

    /**
     * @var string
     *
     * @ORM\Column(name="Min_req", type="text", length=0, nullable=false)
     */
    private $minReq;

    /**
     * @var string
     *
     * @ORM\Column(name="Max_req", type="text", length=0, nullable=false)
     */
    private $maxReq;

    /**
     * @var string
     *
     * @ORM\Column(name="game_slug", type="string", length=250, nullable=false)
     */
    private $gameSlug;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="idGame")
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdGame(): ?int
    {
        return $this->idGame;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
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

    public function getGamePlataform(): ?string
    {
        return $this->gamePlataform;
    }

    public function setGamePlataform(string $gamePlataform): self
    {
        $this->gamePlataform = $gamePlataform;

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

    public function getGameDate(): ?\DateTimeInterface
    {
        return $this->gameDate;
    }

    public function setGameDate(\DateTimeInterface $gameDate): self
    {
        $this->gameDate = $gameDate;

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

    public function getGameValoration(): ?string
    {
        return $this->gameValoration;
    }

    public function setGameValoration(string $gameValoration): self
    {
        $this->gameValoration = $gameValoration;

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

    public function getGameSlug(): ?string
    {
        return $this->gameSlug;
    }

    public function setGameSlug(string $gameSlug): self
    {
        $this->gameSlug = $gameSlug;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
            $idUser->addIdGame($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        if ($this->idUser->removeElement($idUser)) {
            $idUser->removeIdGame($this);
        }

        return $this;
    }

}
