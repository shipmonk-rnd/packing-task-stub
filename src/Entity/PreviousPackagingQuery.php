<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\QueryObject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class PreviousPackagingQuery extends QueryObject
{

    protected const ENTITY_ALIAS = 'pp';

    /**
     * @param Product[] $products
     * @return $this
     */
    public function byProducts(array $products): self
    {
        return $this->add(function (QueryBuilder $qb) use ($products) {
            $qb->join(self::getFieldFullName('products'), 'product')
                ->andWhere('product IN (:products)')
                ->setParameter('products', $products)
                ->addGroupBy(self::getFieldFullName('packaging'))
                ->andHaving('COUNT(DISTINCT product.id) = :productCount')
                ->setParameter('productCount', count($products));
        });
    }

    public function orderBySmallest(): self
    {
        return $this->add(function (QueryBuilder $qb) {
            $qb->join(self::getFieldFullName('packaging'), 'packaging')
                ->addSelect('(' .
                'packaging.width + ' .
                'packaging.height + ' .
                'packaging.length) AS HIDDEN packagingSize')
            ->addOrderBy('packagingSize', 'ASC');
        });
    }

    protected function buildQuery(EntityManagerInterface $em): QueryBuilder
    {
        return $em->createQueryBuilder()->select(self::ENTITY_ALIAS)
            ->from(PreviousPackaging::class, self::ENTITY_ALIAS);
    }

    private static function getFieldFullName(string $field): string
    {
        return self::ENTITY_ALIAS . '.' . $field;
    }
}
