<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(columns={"user_name", "user_email"})})
 * @ORM\Entity
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=30, nullable=false)
     * @Assert\Unique
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pass", type="string", length=60, nullable=false)
     */
    private $userPass;

    /**
     * @var string
     *
     * @ORM\Column(name="user_img", type="string", length=60, nullable=false)
     */
    private $userImg;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     * @Assert\Unique
     */
    private $userEmail;

    /**
     * @var int
     *
     * @ORM\Column(name="user_age", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userAge;

    /**
     * @var string
     *
     * @ORM\Column(name="user_rol", type="string", length=45, nullable=false)
     */
    private $userRol;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Games", inversedBy="idUser")
     * @ORM\JoinTable(name="reviews",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_game", referencedColumnName="id_game")
     *   }
     * )
     */
    private $idGame;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idGame = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function getUserPass(): ?string
    {
        return $this->userPass;
    }

    public function setUserPass(string $userPass): self
    {
        $this->userPass = $userPass;

        return $this;
    }

    public function getUserImg(): ?string
    {
        return $this->userImg;
    }

    public function setUserImg(string $userImg): self
    {
        $this->userImg = $userImg;

        return $this;
    }

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    public function getUserAge(): ?int
    {
        return $this->userAge;
    }

    public function setUserAge(int $userAge): self
    {
        $this->userAge = $userAge;

        return $this;
    }

    /**
     * @return Collection<int, Games>
     */
    public function getIdGame(): Collection
    {
        return $this->idGame;
    }

    public function addIdGame(Games $idGame): self
    {
        if (!$this->idGame->contains($idGame)) {
            $this->idGame[] = $idGame;
        }

        return $this;
    }

    public function removeIdGame(Games $idGame): self
    {
        $this->idGame->removeElement($idGame);

        return $this;
    }

    public function getRoles() :array
    {
        $rol =  $this->userRol;

        return [$rol];
    }

    public function eraseCredentials()
    {

    }

    public function getUserIdentifier(): String
    {
        return $this->userEmail;
    }

    public function getPassword(): string
    {
        return $this->userPass;
    }

    public function setPassword(string $password): self
    {
        $this->userPass = $password;

        return $this;
    }

}
