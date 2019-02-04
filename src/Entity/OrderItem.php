<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 * @ORM\Table(name="order_items")
 */
class OrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"default": 0})
     */
    private $count;

    /**
     * @ORM\Column(type="integer")
     */
    private $ProductPrice;

    /**
     * @ORM\Column(type="integer")
     */
    private $SummaryPrice;

    /**
     * @var Order
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Orders;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Product", inversedBy="orderItems")
     */
    private $product;

    public function __construct()
    {
        $this->count = 0;
        $this->ProductPrice = 0;
        $this->SummaryPrice = 0;
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        $this->updateCost();
        return $this;
    }

    public function addCount(int $value): self
    {
        $this->setCount($this->count + $value);

        return $this;

    }

    public function getProductPrice(): ?int
    {
        return $this->ProductPrice;
    }

    public function setProductPrice(int $ProductPrice): self
    {
        $this->ProductPrice = $ProductPrice;
        $this->updateCost();
        return $this;
    }

    public function getSummaryPrice(): ?int
    {
        return $this->SummaryPrice;
    }

    public function setSummaryPrice(int $SummaryPrice): self
    {
        $this->SummaryPrice = $SummaryPrice;

        return $this;
    }

    public function getOrders(): ?Order
    {
        return $this->Orders;
    }

    public function setOrders(?Order $Orders): self
    {
        $this->Orders = $Orders;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;
        $this->setProductPrice($product->getPrice());

        return $this;
    }

    private function updateCost()
    {
        $this->SummaryPrice = $this->getProductPrice() * $this->getCount();
        if ($this->Orders) {
            $this->Orders->updateOrderPrice();
        }
    }
}
