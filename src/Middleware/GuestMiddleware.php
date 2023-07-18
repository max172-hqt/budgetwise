<?php

namespace Budgetwise\Middleware;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GuestMiddleware
{
    public function handle(Request $request): ?Response
    {
        if ($request->getSession()->get('user') !== null) {
            return new RedirectResponse('/');
        }

        return null;
    }
}