<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reviews
 *
 * @ORM\Table(name="reviews")
 * @ORM\Entity(repositoryClass="App\Repository\ReviewsRepository")
 */
class Reviews
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="Games")
     * @ORM\JoinColumns({
     *  @ORM\JoinColumn(name="id_game", referencedColumnName="id_game")
     * })
     */
    private $idGame;

    /**
     * @var string
     *
     * @ORM\Column(name="review_calification", type="decimal", precision=3, scale=1, nullable=false)
     */
    private $reviewCalification;

    /**
     * @var string
     *
     * @ORM\Column(name="review_desc", type="string", length=250, nullable=false)
     */
    private $reviewDesc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="review_date", type="datetime", nullable=false, options={"default"="current_timestamp()"})
     */
    private $reviewDate = 'current_timestamp()';

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function getIdGame(): ?Games
    {
        return $this->idGame;
    }

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


}
