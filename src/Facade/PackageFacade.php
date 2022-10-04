<?php
declare(strict_types=1);

namespace App\Facade;

use App\Entity\Packaging;
use App\Exception\PackagingNotFoundException;
use App\Model\BinPackaging\Exception\BinPackagingException;
use App\Model\BinPackaging\Service\BinPackagingService;
use App\Repository\PackagingRepository;
use App\Repository\PreviousPackagingRepository;
use App\Service\PreviousPackagingService;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\RequestInterface;

class PackageFacade
{
    private PreviousPackagingRepository $previousPackagingRepository;

    private ProductFacade $productFacade;

    private PreviousPackagingService $previousPackagingService;

    private BinPackagingService $binPackagingService;

    private PackagingRepository $packagingRepository;

    public function __construct(
        PreviousPackagingRepository $previousPackagingRepository,
        ProductFacade $productFacade,
        PreviousPackagingService $previousPackagingService,
        BinPackagingService $binPackagingService,
        PackagingRepository $packagingRepository
    ) {
        $this->previousPackagingRepository = $previousPackagingRepository;
        $this->productFacade = $productFacade;
        $this->previousPackagingService = $previousPackagingService;
        $this->binPackagingService = $binPackagingService;
        $this->packagingRepository = $packagingRepository;
    }

    public function findBestPackaging(EntityManager $entityManager, RequestInterface $request): Packaging
    {
        $rawProductsData = ((array) json_decode($request->getBody()->getContents(), true))['products'] ?? [];
        $products = $this->productFacade->hydrateProducts($entityManager, (array) $rawProductsData);

        $this->previousPackagingRepository->setEntityManager($entityManager);
        try {
            return $this->previousPackagingRepository->findPackagingForProducts($products);
        } catch (PackagingNotFoundException $e) {
        }

        $this->packagingRepository->setEntityManager($entityManager);
        try {
            $packageId = $this->binPackagingService->findBestPacking(
                $products,
                $this->packagingRepository->findAll()
            );
        } catch (BinPackagingException | GuzzleException $e) {
            return $this->packagingRepository->findBiggestBox();
        }

        $previousPackage = $this->previousPackagingService
            ->savePreviousPackageEntry($entityManager, $packageId, $products);
        return $previousPackage->getPackaging();
    }
}
