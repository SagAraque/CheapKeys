<?php

namespace App\Entity;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
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
     * @ORM\Column(name="user_name", type="string", length=20, nullable=false,unique=true)
     * @Assert\Length(
     *      min = 5,
     *      max = 20,
     *      minMessage = "El usuario debe tener más de 5 caracteres",
     *      maxMessage = "El usuario no puede tener más de 20 caracteres"
     * )
     */
    private $userName;

    /**
     * @var string
     *
     * @ORM\Column(name="user_email", type="string", length=50, nullable=false, unique=true)
     * @Assert\NotBlank
     * @Assert\Email(message = "El email no es válido")
     * @Assert\Length(
     *      min = 5,
     *      max = 50,
     *      minMessage = "El email debe tener más de 5 caracteres",
     *      maxMessage = "El email no puede tener más de 50 caracteres"
     * )
     */
    private $userEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="user_pass", type="string", length=60, nullable=false)
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      max = 60,
     *      minMessage = "La contraseña debe tener más de 5 caracteres",
     *      maxMessage = "La contraseña no puede tener más de 60 caracteres"
     * )
     */
    private $userPass;

    /**
     * @var string
     */
    private $newPass;

    /**
     * @var string
     *
     * @ORM\Column(name="user_img", type="string", length=50, nullable=false, options={"default": "default"})
     */
    private $userImg = 'default';

    /**
     * @var string
     *
     * @ORM\Column(name="user_rol", type="string", nullable=false, options={"default": "ROLE_USER"})
     */
    private $userRol = 'ROLE_USER';

    /**
     * @var string
     *
     * @ORM\Column(name="user_state", type="string", nullable=false, options={"default": "ACTIVE"})
     */
    private $userState = 'ACTIVE';

    /**
     * @var \Wishlist::class
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

    /**
     * @return string
     */

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    /**
     * @param string
     */

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }


    /**
     * @return string
     */
    public function getUserEmail(): ?string
    {
        return $this->userEmail;
    }


    /**
     * @param string
     */
    public function setUserEmail(string $userEmail): self
    {
        $this->userEmail = $userEmail;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserPass(): ?string
    {
        return $this->userPass;
    }

    /**
     * @param string
     */
    public function setUserPass(string $userPass): self
    {
        $this->userPass = $userPass;

        return $this;
    }

    /**
     * @return string
     */
    public function getNewPass(): ?string
    {
        return $this->newPass;
    }

    /**
     * @param string
     */
    public function setNewPass(string $newPass): self
    {
        // $this->userPass = password_hash($newPass, PASSWORD_BCRYPT, [null, 10] );
        $this->newPass = $newPass;

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
