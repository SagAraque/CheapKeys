<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Games
 *
 * @ORM\Table(name="games")
 * @ORM\Entity(repositoryClass="App\Repository\GamesRepository")
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
     * @var string
     *
     * @ORM\Column(name="game_plataform", type="string", length=150, nullable=false)
     */
    private $gamePlataform;

    /**
     * @var string
     *
     * @ORM\Column(name="game_developer", type="string", length=100, nullable=false)
     */
    private $gameDeveloper;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="game_date", type="date", nullable=false, options={"default"="current_timestamp()"})
     */
    private $gameDate = 'current_timestamp()';

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

    public function getGameSlug(): ?string
    {
        return $this->gameSlug;
    }

    public function setGameSlug(string $gameSlug): self
    {
        $this->gameSlug = $gameSlug;

        return $this;
    }

    public function __toString()
    {
        return $this->getGameName();
    }


}
