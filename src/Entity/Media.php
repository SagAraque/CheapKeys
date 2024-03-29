<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Media
 *
 * @ORM\Table(name="media")
 * @ORM\Entity(repositoryClass="App\Repository\MediaRepository")
 */
class Media
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_media", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMedia;

    /**
     * @var string
     *
     * @ORM\Column(name="media_url", type="string", length=100, nullable=false)
     */
    private $mediaUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="media_alt", type="string", length=100, nullable=false)
     */
    private $mediaAlt;

    /**
     * @var bool
     *
     * @ORM\Column(name="media_InfoImg", type="boolean", nullable=false)
     */
    private $mediaInfoimg = '0';

    /**
     * @var bool
     *
     * @ORM\Column(name="media_principal", type="boolean", nullable=false)
     */
    private $mediaPrincipal = '0';

    public function getIdMedia(): ?int
    {
        return $this->idMedia;
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

    public function getMediaAlt(): ?string
    {
        return $this->mediaAlt;
    }

    public function setMediaAlt(string $mediaAlt): self
    {
        $this->mediaAlt = $mediaAlt;

        return $this;
    }

    public function isMediaInfoimg(): ?bool
    {
        return $this->mediaInfoimg;
    }

    public function setMediaInfoimg(bool $mediaInfoimg): self
    {
        $this->mediaInfoimg = $mediaInfoimg;

        return $this;
    }

    public function isMediaPrincipal(): ?bool
    {
        return $this->mediaPrincipal;
    }

    public function setMediaPrincipal(bool $mediaPrincipal): self
    {
        $this->mediaPrincipal = $mediaPrincipal;

        return $this;
    }


}
