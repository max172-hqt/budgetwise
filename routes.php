<?php

use Budgetwise\Http\Controller\AboutController;
use Budgetwise\Http\Controller\HomeController;

$router->get('/', [HomeController::class, 'index']);
$router->post('/', [HomeController::class, 'store']);
$router->get('/about/{id}', [AboutController::class, 'index']);
