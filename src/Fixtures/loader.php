<?php

use Budgetwise\Fixtures\TripDataLoader;
use Budgetwise\Fixtures\UserDataLoader;
use Doctrine\Common\DataFixtures\Loader;

$loader = new Loader();

$loader->addFixture(new TripDataLoader());
$loader->addFixture(new UserDataLoader());

return $loader;