<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(): Response {
        return $this->render('index.html.twig');
    }

    public function store(Request $request): Response {
        return new Response("Post Home");
    }
}