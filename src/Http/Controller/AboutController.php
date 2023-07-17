<?php


namespace Budgetwise\Http\Controller;


use Budgetwise\Core\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AboutController extends AbstractController
{
    public function index($request): Response
    {
        return $this->render('about/index.html.twig', [
            'heading' => 'About Us'
        ]);
    }

    public function show($id, $nice): Response
    {
        return $this->render('about/index.html.twig', [
            'heading' => 'About Us'
        ]);
    }
}