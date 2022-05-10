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
     * @ORM\Column(name="game_name", type="string", length=150, nullable=false)
     */
    private $gameName;

    /**
     * @var string
     *
     * @ORM\Column(name="game_slug", type="string", length=100, nullable=false)
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

    public function getGameSlug(): ?string
    {
        return $this->gameSlug;
    }

    public function setGameSlug(string $gameSlug): self
    {
        $this->gameSlug = $gameSlug;

        return $this;
    }


}
