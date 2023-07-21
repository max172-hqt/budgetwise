<?php

use Budgetwise\Entities\Fixtures\TripDataLoader;
use Budgetwise\Entities\Fixtures\UserDataLoader;
use Doctrine\Common\DataFixtures\Loader;

$loader = new Loader();

$loader->addFixture(new TripDataLoader());
$loader->addFixture(new UserDataLoader());

return $loader;