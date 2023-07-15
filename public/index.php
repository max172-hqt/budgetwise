<?php


use Budgetwise\Core\Router;
use Symfony\Component\HttpFoundation\Request;


const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'src/Utilities/functions.php';

require base_path('/vendor/autoload.php');
require base_path('bootstrap.php');

$request = Request::createFromGlobals();
$router = new Router();

$routesSetup = require base_path('routes.php');
$routesSetup($router);

$response = $router->handle($request);
$response->send();

