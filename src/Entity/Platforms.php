<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Platforms
 *
 * @ORM\Table(name="platforms")
 * @ORM\Entity(repositoryClass="App\Repository\PlatformsRepository")
 */
class Platforms
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_platform", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPlatform;

    /**
     * @var string
     *
     * @ORM\Column(name="platform_name", type="string", length=50, nullable=false)
     */
    private $platformName;

    public function getIdPlatform(): ?int
    {
        return $this->idPlatform;
    }

    public function getPlatformName(): ?string
    {
        return $this->platformName;
    }

    public function setPlatformName(string $platformName): self
    {
        $this->platformName = $platformName;

        return $this;
    }


}
