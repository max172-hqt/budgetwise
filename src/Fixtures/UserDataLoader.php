<?php

namespace Budgetwise\Fixtures;

use Budgetwise\Entities\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserDataLoader extends AbstractFixture implements FixtureInterface
{
    public const COUNT = 4;
    public const REFERENCE_PREFIX = 'users';

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::COUNT; $i++) {
            $user = new User();
            $user->setName("user{$i}");
            $user->setEmail("user{$i}@example.com");
            $user->setPassword(12345678);
            $manager->persist($user);

            $this->addReference(self::REFERENCE_PREFIX . '_' . $i , $user);
        }

        $manager->flush();
    }
}