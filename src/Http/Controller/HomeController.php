<?php

namespace Budgetwise\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    public function index(): Response {
        return new Response("Home");
    }

    public function store(Request $request): Response {
        return new Response("Post Home");
    }
}