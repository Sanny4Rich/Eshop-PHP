<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Service\OrdersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    /**
     * @Route("/orders", name="orders")
     */
    public function index()
    {
        return $this->render('orders/index.html.twig', [
            'controller_name' => 'OrdersController',
        ]);
    }

    /**
     * @Route("/orders/add-to-catr/{id}", name="orders_add_to_cart")
     */
    public function addToCart(Product $product, OrdersService $ordersService, Request $request)
    {
        $order = $ordersService->addToCart($product);

        if($request->isXmlHttpRequest()){
            $response = $this->render('order/cartInHeader.html.twig', [
                'cart' => $order,
            ]);
        } else {
            $referer = $request->headers->get('referer');
            $response = $this->redirect($referer);
            $response->headers->setCookie(new Cookie('orderId', $order->getId(), new \DateTime('+1 year')));
        }
        return $response;
    }

    /**
     * @Route("/orders/cart-in-header", name="orders_cart_in_header")
     */
    public function cartInHeader(OrdersService $ordersService) {
        $cart = $ordersService->getOrderFromRequest();


        return $this->render('order/cartInHeader.html.twig', ['cart' => $cart]);
    }

    /**
     * @Route("/orders/cart", name="orders")
     */

    public function cart(OrdersService $ordersService)
    {
        return $this->render('orders/index.html.twig', [
            'cart' => $ordersService->getOrderFromRequest()
        ]);
    }
}
