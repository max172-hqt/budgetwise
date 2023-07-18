<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index($request): Response {
        return $this->render('home/index.html.twig', [
            'heading' => 'Your Trips',
            'name' => 'Huy Tran',
        ]);
    }
}