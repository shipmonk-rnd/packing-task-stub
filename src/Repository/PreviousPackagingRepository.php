<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Packaging;
use App\Entity\PackagingQuery;
use App\Entity\PreviousPackaging;
use App\Entity\PreviousPackagingQuery;
use App\Entity\Product;
use App\Exception\PackagingNotFoundException;

class PreviousPackagingRepository extends BaseRepository
{
    /**
     * @param Product[] $products
     * @return Packaging
     * @throws PackagingNotFoundException
     */
    public function findPackagingForProducts(array $products): Packaging
    {
        $previousPackaging = (new PreviousPackagingQuery())
            ->byProducts($products)
            ->orderBySmallest()
            ->fetchOne($this->getEntityManager());

        if ($previousPackaging instanceof PreviousPackaging === false) {
            throw new PackagingNotFoundException();
        }

        return $previousPackaging->getPackaging();
    }
}
