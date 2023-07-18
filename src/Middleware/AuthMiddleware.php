<?php

namespace Budgetwise\Middleware;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthMiddleware
{
    public function handle(Request $request)
    {
        if (null === $request->getSession()->get('user')) {
            return new RedirectResponse('/');
        }
    }
}