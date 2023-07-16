<?php

namespace Budgetwise\Core;

use Doctrine\ORM\EntityManager;

class Database
{
    protected EntityManager $entityManager;

    public function __construct($config, $connection) {
        $this->entityManager = new EntityManager($connection, $config);
    }

    public function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function persist($obj): void
    {
        $this->entityManager->persist($obj);
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}