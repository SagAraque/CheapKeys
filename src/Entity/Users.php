<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="user_name", type="string", length=30, nullable=false)
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
     */
    private $userEmail;

    /**
     * @var int
     *
     * @ORM\Column(name="user_age", type="integer", nullable=false, options={"unsigned"=true})
     */
    private $userAge;

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


}
