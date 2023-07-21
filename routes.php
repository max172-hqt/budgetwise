<?php

use Budgetwise\Core\Router;
use Budgetwise\Http\Controller\AboutController;
use Budgetwise\Http\Controller\TransactionController;
use Budgetwise\Http\Controller\TripController;
use Budgetwise\Http\Controller\RegistrationController;
use Budgetwise\Http\Controller\SessionController;

return function (Router $router) {
    $router->get('/', [TripController::class, 'index']);
    $router->get('/trips/create', [TripController::class, 'create', 'auth']);
    $router->get('/trips/{id}', [TripController::class, 'show', 'auth']);
    $router->post('/trips/{id}', [TransactionController::class, 'store', 'auth']);
    $router->post('/trips', [TripController::class, 'store', 'auth']);

    $router->get('/about', [AboutController::class, 'index']);

    $router->get('/registration', [RegistrationController::class, 'index', 'guest']);
    $router->post('/registration', [RegistrationController::class, 'store', 'guest']);

    $router->get('/login', [SessionController::class, 'index', 'guest']);
    $router->post('/session', [SessionController::class, 'store', 'guest']);
    $router->delete('/session', [SessionController::class, 'destroy', 'auth']);
};
