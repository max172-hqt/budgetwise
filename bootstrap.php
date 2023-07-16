<?php


use Budgetwise\Core\App;
use Budgetwise\Core\Container;
use Budgetwise\Core\Database;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\ORMSetup;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

// ================ SET UP SERVICE PROVIDERS ================
$container = new Container();

// ================ SET UP TWIG ================

$container->singleton('twig', function () {
    $loader = new FilesystemLoader(base_path('templates'));
    return new Environment($loader);
});


// ================ SET UP DOCTRINE CONFIGURATION ================
// Command to update database scheme: php bin/doctrine orm:schema-tool:update --force

$container->singleton(
    /**
    * @throws MissingMappingDriverImplementation
    * @throws \Doctrine\DBAL\Exception
    */ Database::class, function () {
    $ormConfig = ORMSetup::createAttributeMetadataConfiguration(
        paths: array(__DIR__ . "/src"),
        isDevMode: true,
    );

    $dbConfig = require base_path('config/database.php');
    $connection = DriverManager::getConnection($dbConfig['sqlite'], $ormConfig);
    return new Database($ormConfig, $connection);
});

App::setContainer($container);
