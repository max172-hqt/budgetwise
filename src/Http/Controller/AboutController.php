<?php

namespace Budgetwise\Http\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AboutController
{
    public function index(Request $request): Response
    {
        return new Response("About");
    }
}