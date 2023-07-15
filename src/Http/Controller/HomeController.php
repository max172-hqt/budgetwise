<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(): Response {
        return $this->render('home/index.html.twig', [
            'name' => 'Huy Tran',
        ]);
    }

    public function store(): Response {
        return new Response("Post Home");
    }
}