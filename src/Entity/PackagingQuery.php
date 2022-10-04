<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\QueryObject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class PackagingQuery extends QueryObject
{

    protected const ENTITY_ALIAS = 'pa';

    /**
     * @param Product[] $products
     * @return $this
     */
    public function byProducts(array $products): self
    {
        return $this->add(function (QueryBuilder $qb) use ($products) {
            $qb->join(self::getFieldFullName('products'), 'product')
                ->andWhere('product IN (:products)')
                ->setParameter('products', $products);
        });
    }

    public function orderBySize(): self
    {
        return $this->add(function (QueryBuilder $qb) {
            $qb->addSelect('(' .
                'packaging.width + ' .
                'packaging.height + ' .
                'packaging.length) AS HIDDEN packagingSize')
               ->addOrderBy('packagingSize', 'ASC');
        });
    }

    protected function buildQuery(EntityManagerInterface $em): QueryBuilder
    {
        return $em->createQueryBuilder()->select(self::ENTITY_ALIAS)
            ->from(Packaging::class, self::ENTITY_ALIAS);
    }

    private static function getFieldFullName(string $field): string
    {
        return self::ENTITY_ALIAS . '.' . $field;
    }
}
