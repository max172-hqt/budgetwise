<?php


use Budgetwise\Core\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;


const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'src/Utilities/functions.php';

require base_path('/vendor/autoload.php');
$container = require base_path('bootstrap.php');

$session = new Session();
$session->start();

$request = Request::createFromGlobals();
$request->setSession($session);
$router = new Router($container);

$routesSetup = require base_path('routes.php');
$routesSetup($router);

$response = $router->handle($request);
$response->send();

