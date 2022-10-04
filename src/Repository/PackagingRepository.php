<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Packaging;
use App\Entity\PackagingQuery;
use App\Entity\Product;
use App\Exception\PackagingNotFoundException;

class PackagingRepository extends BaseRepository
{
    /**
     * @param Product[] $products
     * @return Packaging
     * @throws PackagingNotFoundException
     */
    public function findPackagingForProducts(array $products): Packaging
    {
        $packaging = (new PackagingQuery())
            ->byProducts($products)
            ->fetchOne($this->getEntityManager());

        if ($packaging instanceof Packaging === false) {
            throw new PackagingNotFoundException();
        }

        return $packaging;
    }

    /**
     * @return Packaging[]
     */
    public function findAll(): array
    {
        /** @var Packaging[] $packagings */
        $packagings = (new PackagingQuery())
            ->fetch($this->getEntityManager());
        return $packagings;
    }

    public function findBiggestBox(): Packaging
    {
        /** @var Packaging $packaging */
        $packaging = (new PackagingQuery())
            ->orderBySize()
            ->fetchOne($this->getEntityManager());
        return $packaging;
    }
}
