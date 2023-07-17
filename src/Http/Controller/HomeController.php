<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Entities\Product;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index($request): Response {
        return $this->render('home/index.html.twig', [
            'heading' => 'Your Trips',
            'name' => 'Huy Tran',
        ]);
    }

    public function store(): Response {
        $product = new Product();
        $product->setName("New Product");
        $this->db->persist($product);
        $this->db->flush();
        return new Response($product->getName());
    }
}