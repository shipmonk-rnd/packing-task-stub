<?php
declare(strict_types=1);

namespace App\Helper;

use App\Entity\Product;
use InvalidArgumentException;

class ProductMapper
{
    public const FIELD_ID = 'id';
    public const FIELD_WIDTH = 'width';
    public const FIELD_HEIGHT = 'height';
    public const FIELD_LENGTH = 'length';
    public const FIELD_WEIGHT = 'weight';

    private const REQUIRED_FIELDS = [
        self::FIELD_ID,
        self::FIELD_WIDTH,
        self::FIELD_HEIGHT,
        self::FIELD_LENGTH,
        self::FIELD_WEIGHT,
    ];

    /**
     * @param array<int|float> $productData
     * @return Product
     */
    public static function mapProduct(array $productData): Product
    {
        if (self::validateProductData($productData) === false) {
            throw new InvalidArgumentException('Missing required fields for product');
        }

        $product = new Product(
            (float) $productData[self::FIELD_WIDTH],
            (float) $productData[self::FIELD_HEIGHT],
            (float) $productData[self::FIELD_LENGTH],
            (float) $productData[self::FIELD_WEIGHT],
        );
        $product->setId((int) $productData[self::FIELD_ID]);

        return $product;
    }

    /**
     * @param array<int|float> $productData
     * @return bool
     */
    private static function validateProductData(array $productData): bool
    {
        return count(array_intersect_key(array_flip(
            self::REQUIRED_FIELDS
        ), $productData)) === count(self::REQUIRED_FIELDS);
    }
}
