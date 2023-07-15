<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AboutController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('about/index.html.twig', [
            'heading' => 'About Us'
        ]);
    }
}