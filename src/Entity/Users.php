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
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="EmailIndex", columns={"user_email"}), @ORM\UniqueConstraint(name="user_name", columns={"user_name"})}, indexes={@ORM\Index(name="FK4", columns={"user_wishlist"})})
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
     * @ORM\Column(name="user_name", type="string", length=100, nullable=false)
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=100, nullable=false)
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pass", type="string", length=60, nullable=false)
     */
    private $userPass;

    /**
     * @var string
     *
     * @ORM\Column(name="user_img", type="string", length=50, nullable=false, options={"default"="'default.webp'"})
     */
    private $userImg = '\'default.webp\'';

    /**
     * @var string
     *
     * @ORM\Column(name="user_rol", type="string", length=0, nullable=false, options={"default"="'ROLE_USER'"})
     */
    private $userRol = '\'ROLE_USER\'';

    /**
     * @var string
     *
     * @ORM\Column(name="user_state", type="string", length=0, nullable=false, options={"default"="'ACTIVE'"})
     */
    private $userState = '\'ACTIVE\'';

    /**
     * @var \Wishlist
     *
     * @ORM\ManyToOne(targetEntity="Wishlist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_wishlist", referencedColumnName="id_wishlist")
     * })
     */
    private $userWishlist;

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

    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }

    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

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

    public function getUserRol(): ?string
    {
        return $this->userRol;
    }

    public function setUserRol(string $userRol): self
    {
        $this->userRol = $userRol;

        return $this;
    }

    public function getUserState(): ?string
    {
        return $this->userState;
    }

    public function setUserState(string $userState): self
    {
        $this->userState = $userState;

        return $this;
    }

    public function getUserWishlist(): ?Wishlist
    {
        return $this->userWishlist;
    }

    public function setUserWishlist(?Wishlist $userWishlist): self
    {
        $this->userWishlist = $userWishlist;

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
