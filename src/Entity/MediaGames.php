<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * MediaGames
 *
 * @ORM\Table(name="media_games", indexes={@ORM\Index(name="FK24", columns={"id_platform"}), @ORM\Index(name="FK25", columns={"id_game"}), @ORM\Index(name="IDX_1A4E509484A9E03C", columns={"id_media"})})
 * @ORM\Entity(repositoryClass="App\Repository\MediaGamesRepository")
 */
class MediaGames
{
    /**
     * @var \Platforms:::class
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
     * @var \Media::class
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Media")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_media", referencedColumnName="id_media")
     * })
     */
    private $idMedia;

    /**
     * @var \Games::class
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_game", referencedColumnName="id_game")
     * })
     */
    private $idGame;

    public function getIdPlatform(): ?Platforms
    {
        return $this->idPlatform;
    }

    public function setIdPlatform(?Platforms $idPlatform): self
    {
        $this->idPlatform = $idPlatform;

        return $this;
    }

    public function getIdMedia(): ?Media
    {
        return $this->idMedia;
    }

    public function setIdMedia(?Media $idMedia): self
    {
        $this->idMedia = $idMedia;

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
