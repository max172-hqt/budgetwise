<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Budgetwise\Core\Database;
use Budgetwise\Entities\Product;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(): Response {
        return $this->render('home/index.html.twig', [
            'heading' => 'Your Trips',
            'name' => 'Huy Tran',
        ]);
    }

    public function store(): Response {
        $product = new Product();
        $product->setName("New Product");
        $db = $this->container()->resolve(Database::class);
        $db->persist($product);
        $db->flush();
        return new Response($product->name());
    }
}