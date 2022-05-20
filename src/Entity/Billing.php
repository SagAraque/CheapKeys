<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Billing
 *
 * @ORM\Table(name="billing", indexes={@ORM\Index(name="FK1", columns={"id_user"})})
 * @ORM\Entity(repositoryClass="App\Repository\BillingRepository")
 */
class Billing
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_billing", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBilling;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_name", type="text", length=65535, nullable=false)
     */
    private $billingName;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_state", type="string", length=0, nullable=false, options={"default"="'ACTIVE'"})
     */
    private $billingState = '\'ACTIVE\'';

    /**
     * @var string
     *
     * @ORM\Column(name="billing_direction", type="string", length=150, nullable=false)
     */
    private $billingDirection;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_postal", type="string", length=5, nullable=false)
     */
    private $billingPostal;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_poblation", type="string", length=100, nullable=false)
     */
    private $billingPoblation;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_country", type="string", length=100, nullable=false)
     */
    private $billingCountry;

    /**
     * @var string
     *
     * @ORM\Column(name="billing_province", type="string", length=100, nullable=false)
     */
    private $billingProvince;

    /**
     * @var string
     *
     * @ORM\Column(name="billin_tlfo", type="string", length=11, nullable=false)
     */
    private $billinTlfo;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdBilling(): ?int
    {
        return $this->idBilling;
    }

    public function getBillingState(): ?string
    {
        return $this->billingState;
    }

    public function setBillingState(string $billingState): self
    {
        $this->billingState = $billingState;

        return $this;
    }

    public function getBillingDirection(): ?string
    {
        return $this->billingDirection;
    }

    public function setBillingDirection(string $billingDirection): self
    {
        $this->billingDirection = $billingDirection;

        return $this;
    }

    public function getBillingPostal(): ?string
    {
        return $this->billingPostal;
    }

    public function setBillingPostal(string $billingPostal): self
    {
        $this->billingPostal = $billingPostal;

        return $this;
    }

    public function getBillingPoblation(): ?string
    {
        return $this->billingPoblation;
    }

    public function setBillingPoblation(string $billingPoblation): self
    {
        $this->billingPoblation = $billingPoblation;

        return $this;
    }

    public function getBillingCountry(): ?string
    {
        return $this->billingCountry;
    }

    public function setBillingCountry(string $billingCountry): self
    {
        $this->billingCountry = $billingCountry;

        return $this;
    }

    public function getBillingProvince(): ?string
    {
        return $this->billingProvince;
    }

    public function setBillingProvince(string $billingProvince): self
    {
        $this->billingProvince = $billingProvince;

        return $this;
    }

    public function getBillinTlfo(): ?string
    {
        return $this->billinTlfo;
    }

    public function setBillinTlfo(string $billinTlfo): self
    {
        $this->billinTlfo = $billinTlfo;

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

    public function getBillingName(): ?string
    {
        return $this->billingName;
    }

    public function setBillingName(string $billingName): self
    {
        $this->billingName = $billingName;

        return $this;
    }


}
