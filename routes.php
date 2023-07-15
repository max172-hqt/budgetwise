<?php

use Budgetwise\Core\Router;
use Budgetwise\Http\Controller\AboutController;
use Budgetwise\Http\Controller\HomeController;

return function (Router $router) {
    $router->get('/', [HomeController::class, 'index']);
    $router->post('/', [HomeController::class, 'store']);

    $router->get('/about', [AboutController::class, 'index']);
};
