<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="orders")
 */
class Order
{
    const STATUS_NEW = 1; // новый
    const STATUS_ORDERED = 2; //заказан
    const STATUS_SENT = 3; //отправлен
    const STATUS_RECIVED = 4;//получен
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer", options={"default": 1})
     */
     private $status;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $PayStatus;

    /**
     * @ORM\Column(type="integer")
     */
    private $OrderPrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $user;

    /**
     * @var OrderItem[]
     *
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="Orders",
     *     orphanRemoval=true, indexBy="product_id", cascade={"persist"})
     *
     */
    private $items;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     * @Assert\Regex(groups={"createOrder"}, pattern="|^[-+ \d\(\)]+$|")
     */
    private $PhoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     * @Assert\Email(groups={"createOrder"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Assert\NotBlank(groups={"createOrder"})
     */
    private $adress;

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->createdAt= new \DateTime();
        $this->status = self::STATUS_NEW;
        $this->OrderPrice = 0;
        $this->PayStatus = false;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPayStatus(): ?bool
    {
        return $this->PayStatus;
    }

    public function setPayStatus(bool $PayStatus): self
    {
        $this->PayStatus = $PayStatus;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getOrderPrice(): ?int
    {
        return $this->OrderPrice;
    }

    public function setOrderPrice(int $OrderPrice): self
    {
        $this->OrderPrice = $OrderPrice;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setOrders($this);
        }

        $this->updateOrderPrice();
        return $this;
    }

    public function removeItem(OrderItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getOrders() === $this) {
                $item->setOrders(null);
            }
        }

        $this->updateOrderPrice();

        return $this;
    }

    public function updateOrderPrice(){
        $orderPrice = 0;
        foreach ($this->getItems() as $item){
            $orderPrice += $item->getSummaryPrice();
        }

        $this->setOrderPrice($orderPrice);
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->PhoneNumber;
    }

    public function setPhoneNumber(?string $PhoneNumber): self
    {
        $this->PhoneNumber = $PhoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }
}
