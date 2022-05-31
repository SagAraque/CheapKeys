<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orders
 *
 * @ORM\Table(name="orders", indexes={@ORM\Index(name="FK3", columns={"id_billing"}), @ORM\Index(name="FK27", columns={"id_cart"}), @ORM\Index(name="FK2", columns={"id_user"})})
 * @ORM\Entity
 */
class Orders
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_order", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOrder;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="order_date", type="date", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $orderDate = 'current_timestamp()';

    /**
     * @var string
     *
     * @ORM\Column(name="order_total", type="decimal", precision=5, scale=2, nullable=false, options={"default"="0.00"})
     */
    private $orderTotal = '0.00';

    /**
     * @var \Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_cart", referencedColumnName="id_cart")
     * })
     */
    private $idCart;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Billing
     *
     * @ORM\ManyToOne(targetEntity="Billing")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_billing", referencedColumnName="id_billing")
     * })
     */
    private $idBilling;

    public function getIdOrder(): ?int
    {
        return $this->idOrder;
    }

    public function getOrderDate(): ?\DateTimeInterface
    {
        return $this->orderDate;
    }

    public function setOrderDate(\DateTimeInterface $orderDate): self
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    public function getOrderTotal(): ?string
    {
        return $this->orderTotal;
    }

    public function setOrderTotal(string $orderTotal): self
    {
        $this->orderTotal = $orderTotal;

        return $this;
    }

    public function getIdCart(): ?Cart
    {
        return $this->idCart;
    }

    public function setIdCart(?Cart $idCart): self
    {
        $this->idCart = $idCart;

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

    public function getIdBilling(): ?Billing
    {
        return $this->idBilling;
    }

    public function setIdBilling(?Billing $idBilling): self
    {
        $this->idBilling = $idBilling;

        return $this;
    }


}
