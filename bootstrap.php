<?php

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions(base_path('config/container.php'));
$container = $containerBuilder->build();

return $container;