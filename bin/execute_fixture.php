#!/usr/bin/env php
<?php

use Budgetwise\Core\Database;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'src/Utilities/functions.php';

require base_path('/vendor/autoload.php');
require base_path('bootstrap.php');

$loader = require base_path('src/Fixtures/loader.php');
$db = $container->get(Database::class);

$executor = new ORMExecutor($db->entityManager(), new ORMPurger());
$executor->execute($loader->getFixtures());

echo "Execute successfully\n";