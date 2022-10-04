<?php
declare(strict_types=1);

namespace App\Facade;

use App\Entity\Product;
use App\Exception\EntityNotFoundException;
use App\Helper\ProductMapper;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;

class ProductFacade
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param EntityManager $entityManager
     * @param array<array<mixed>> $rawProductsData
     * @return Product[]
     */
    public function hydrateProducts(EntityManager $entityManager, array $rawProductsData): array
    {
        $this->productRepository->setEntityManager($entityManager);
        return array_map(function (array $rawProductData) use ($entityManager) : Product {
            try {
                return $this->productRepository->findById($rawProductData[ProductMapper::FIELD_ID]);
            } catch (EntityNotFoundException $e) {
                $product = ProductMapper::mapProduct($rawProductData);
                $entityManager->persist($product);
                $entityManager->flush();
                return $product;
            } catch (\Throwable $e) {
                return ProductMapper::mapProduct($rawProductData);
            }
        }, $rawProductsData);
    }
}
