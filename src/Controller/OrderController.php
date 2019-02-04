<?php

namespace App\Controller;

use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     */
    public function index($id, OrderRepository $orderRepository)
    {
        $order = $orderRepository->find($id);
        if (!$order){
            throw $this->$this->createNotFoundException('Заказ #'.$id.' не найден');
        }
        return $this->render('order/index.html.twig', [
            'order'=>$order,
        ]);
    }
}
