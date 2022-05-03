<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media", indexes={@ORM\Index(name="fk_id_game_media", columns={"id_game"})})
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_media", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idMedia;

    /**
     * @var string|null
     *
     * @ORM\Column(name="media_alt", type="string", length=100, nullable=true, options={"default"="NULL"})
     */
    private $mediaAlt = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="media_url", type="string", length=50, nullable=false)
     */
    private $mediaUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="media_infoImg", type="boolean", nullable=false)
     */
    private $mediaInfoimg;

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

    public function getIdMedia(): ?int
    {
        return $this->idMedia;
    }

    public function getMediaAlt(): ?string
    {
        return $this->mediaAlt;
    }

    public function setMediaAlt(?string $mediaAlt): self
    {
        $this->mediaAlt = $mediaAlt;

        return $this;
    }

    public function getMediaUrl(): ?string
    {
        return $this->mediaUrl;
    }

    public function setMediaUrl(string $mediaUrl): self
    {
        $this->mediaUrl = $mediaUrl;

        return $this;
    }

    public function getMediaInfoimg(): ?bool
    {
        return $this->mediaInfoimg;
    }

    public function setMediaInfoimg(bool $mediaInfoimg): self
    {
        $this->mediaInfoimg = $mediaInfoimg;

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
