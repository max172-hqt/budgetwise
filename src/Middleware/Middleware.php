<?php

namespace Budgetwise\Middleware;

use Symfony\Component\HttpFoundation\Response;

class Middleware
{
    public const MIDDLEWARE_MAP = [
        'auth' => AuthMiddleware::class,
        'guest' => GuestMiddleware::class,
    ];

    /**
     * @throws \Exception
     */
    public static function resolve($key, $request): ?Response
    {
        $middleware = Middleware::MIDDLEWARE_MAP[$key];

        if (null === $middleware) {
            throw new \Exception("No matching middleware for key: {$key}");
        }

        return (new $middleware)->handle($request);
    }
}