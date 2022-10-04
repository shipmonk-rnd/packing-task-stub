<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Exception\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

class ProductRepository extends BaseRepository
{
    /**
     * @throws EntityNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     */
    public function findById(int $id): Product
    {
        $product = $this->getEntityManager()->find(Product::class, $id);

        if ($product instanceof Product === false) {
            throw EntityNotFoundException::byId(Product::class, $id);
        }

        return $product;
    }
}
