<?php

namespace Budgetwise\Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\MissingMappingDriverImplementation;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Database
{
    protected EntityManager $entityManager;

    /**
     * @throws MissingMappingDriverImplementation
     */
    public function __construct($config, $connection) {
        $this->entityManager = new EntityManager($connection, $config);
    }

    public function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @throws ORMException
     */
    public function persist($obj): void
    {
        $this->entityManager->persist($obj);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function persistAndFlush($obj): void
    {
        $this->persist($obj);
        $this->flush();
    }
}