<?php

namespace Budgetwise\Fixtures;

use Budgetwise\Entities\Trip;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TripDataLoader extends AbstractFixture implements FixtureInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $trip = new Trip();
        $trip->setName("Toronto Summer 2023 Trip");

        for ($i = 0; $i < UserDataLoader::COUNT; $i++) {
            $user = $this->getReference(UserDataLoader::REFERENCE_PREFIX . '_' . $i);
            $trip->addUser($user);
        }

        $manager->persist($trip);
        $manager->flush();
    }


    public function getDependencies(): array
    {
        return [UserDataLoader::class];
    }
}