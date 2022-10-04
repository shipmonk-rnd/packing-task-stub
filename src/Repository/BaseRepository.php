<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManager;

class BaseRepository
{
    private EntityManager $entityManager;

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManager $entityManager): void
    {
        $this->entityManager = $entityManager;
    }
}
