<?php

namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class OrdersService
{

    private $request;

    private $ordersRepository;

    private $entityManager;

    public function __construct(
        RequestStack $requestStack,
        OrderRepository $orderRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->request = $requestStack->getCurrentRequest();
        $this->ordersRepository = $orderRepository;
        $this->entityManager = $entityManager;
    }

    public function addToCart(Product $product): Order
    {
        $order = $this->getOrderFromRequest();
        $items = $order->getItems();

        if ($items[$product->getId()]) {
            $items[$product->getId()]->addCount(1);
        } else {
            $item = new OrderItem();
            $item->setProduct($product);
            $item->setCount(1);
            $order->addItem($item);
            $this->entityManager->persist($item);
        }

        $this->entityManager->flush();

        return $order;
    }

    public function getOrderFromRequest()
    {
        $order = null;
        $orderId = $this->request->cookies->get('orderId');

        if ($orderId){
            $order = $this->ordersRepository->find($orderId);
        }

        if (!$orderId){
            $order = new Order();
            $this->entityManager->persist($order);
        }

        return $order;

    }

}