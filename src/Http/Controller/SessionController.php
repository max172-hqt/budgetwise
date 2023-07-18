<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionController extends AbstractController
{
    public function index(Request $request): Response
    {
        return $this->render('session/create.html.twig', [
            'heading' => 'Log In',
        ]);
    }
}