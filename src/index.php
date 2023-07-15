<?php


use Budgetwise\Core\Router;
use Symfony\Component\HttpFoundation\Request;


const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . '/vendor/autoload.php';


$request = Request::createFromGlobals();
$router = new Router();

require 'routes.php';

$response = $router->handle($request);
$response->send();

