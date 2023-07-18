<?php

namespace Budgetwise\Http\Controller;

use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    public function index(Request $request): Response
    {
        $user = $request->getSession()->get('user');

        return $this->render('home/index.html.twig', [
            'heading' => 'Your Trips',
            'email' => $user ? $user['email'] : 'Guest'
        ]);
    }
}