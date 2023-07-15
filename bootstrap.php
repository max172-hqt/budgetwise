<?php


use Budgetwise\Core\App;
use Budgetwise\Core\Container;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$container = new Container();

$container->bind('twig', function () {
    $loader = new FilesystemLoader(base_path('templates'));
    return new Environment($loader);
});

App::setContainer($container);