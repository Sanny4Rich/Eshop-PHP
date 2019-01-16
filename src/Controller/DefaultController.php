<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="MainPage")
     */
    public function index(ProductRepository $productRepository)
    {

        $products = $productRepository->findBy(
            ['isTop' => true],
            ['id' =>'ASC']);

        return $this->render('default/index.html.twig', [
            'products' => $products,
        ]);
    }
}
