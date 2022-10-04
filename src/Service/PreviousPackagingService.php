<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Packaging;
use App\Entity\PreviousPackaging;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;

class PreviousPackagingService
{

    /**
     * @param EntityManager $entityManager
     * @param int $packageId
     * @param Product[] $products
     * @return PreviousPackaging
     */
    public function savePreviousPackageEntry(
        EntityManager $entityManager,
        int $packageId,
        array $products
    ): PreviousPackaging {
        $previousPackaging = new PreviousPackaging();

        /** @var Packaging $packaging */
        $packaging = $entityManager->getReference(Packaging::class, $packageId);

        $previousPackaging->setPackaging($packaging);
        foreach ($products as $product) {
            $previousPackaging->addProduct($product);
        }
        $entityManager->persist($previousPackaging);
        $entityManager->flush();
        return $previousPackaging;
    }
}
