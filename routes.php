<?php

use Budgetwise\Core\Router;
use Budgetwise\Http\Controller\AboutController;
use Budgetwise\Http\Controller\HomeController;
use Budgetwise\Http\Controller\RegistrationController;
use Budgetwise\Http\Controller\SessionController;

return function (Router $router) {
    $router->get('/', [HomeController::class, 'index']);
    $router->get('/about', [AboutController::class, 'index']);

    $router->get('/registration', [RegistrationController::class, 'index', 'guest']);
    $router->post('/registration', [RegistrationController::class, 'store', 'guest']);

    $router->get('/login', [SessionController::class, 'index', 'guest']);
};
