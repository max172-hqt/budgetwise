<?php


use Budgetwise\Core\Database;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


return [
    Environment::class => function () {
        $loader = new FilesystemLoader(base_path('templates'));
        return new Environment($loader);
    },

    Database::class => function () {
        $ormConfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: array(base_path("/src")),
            isDevMode: true,
        );

        $dbConfig = require base_path('config/database.php');
        $connection = DriverManager::getConnection($dbConfig['sqlite'], $ormConfig);
        return new Database($ormConfig, $connection);
    }
];