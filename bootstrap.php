<?php


use Budgetwise\Core\App;
use Budgetwise\Core\Container;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// ================ SET UP TWIG ================
$container = new Container();

$container->bind('twig', function () {
    $loader = new FilesystemLoader(base_path('templates'));
    return new Environment($loader);
});

App::setContainer($container);

// ================ SET UP ORM CONFIGURATION ================

/**
 * @throws MissingMappingDriverImplementation
 * @throws \Doctrine\DBAL\Exception
 */
$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: array(__DIR__."/src"),
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/db.sqlite',
], $config);

$entitiyManager = new EntityManager($connection, $config);
