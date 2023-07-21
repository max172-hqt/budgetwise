<?php

use Budgetwise\Core\Database;
use Budgetwise\Core\MoneyFormatter;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\ORMSetup;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;

return [
    Environment::class => function () {
        $loader = new FilesystemLoader(base_path('templates'));
        $env = new Environment($loader);

        // Add Filters
        $filter = new TwigFilter('format_money', [MoneyFormatter::class, 'format']);
        $env->addFilter($filter);

        return $env;
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