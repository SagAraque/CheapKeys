<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reviews
 *
 * @ORM\Table(name="reviews", indexes={@ORM\Index(name="FK14", columns={"id_game"}), @ORM\Index(name="FK15", columns={"id_user"}), @ORM\Index(name="FK16", columns={"id_plaftorm"})})
 * @ORM\Entity(repositoryClass="App\Repository\ReviewsRepository")
 */
class Reviews
{
    /**
     * @var string
     *
     * @ORM\Column(name="review_calification", type="decimal", precision=2, scale=1, nullable=false)
     */
    private $reviewCalification;

    /**
     * @var string
     *
     * @ORM\Column(name="review_desc", type="string", length=255, nullable=false)
     */
    private $reviewDesc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="review_date", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $reviewDate = 'current_timestamp()';

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

    /**
     * @var \Platforms::class
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Platforms")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_plaftorm", referencedColumnName="id_platform")
     * })
     */
    private $idPlaftorm;

    /**
     * @var \Users:classd
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getReviewCalification(): ?string
    {
        return $this->reviewCalification;
    }

    public function setReviewCalification(string $reviewCalification): self
    {
        $this->reviewCalification = $reviewCalification;

        return $this;
    }

    public function getReviewDesc(): ?string
    {
        return $this->reviewDesc;
    }

    public function setReviewDesc(string $reviewDesc): self
    {
        $this->reviewDesc = $reviewDesc;

        return $this;
    }

    public function getReviewDate(): ?\DateTimeInterface
    {
        return $this->reviewDate;
    }

    public function setReviewDate(\DateTimeInterface $reviewDate): self
    {
        $this->reviewDate = $reviewDate;

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

    public function getIdPlaftorm(): ?Platforms
    {
        return $this->idPlaftorm;
    }

    public function setIdPlaftorm(?Platforms $idPlaftorm): self
    {
        $this->idPlaftorm = $idPlaftorm;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }


}
