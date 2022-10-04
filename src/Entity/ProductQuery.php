<?php

declare(strict_types=1);

namespace App\Entity;

use App\Model\QueryObject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

class ProductQuery extends QueryObject
{

    protected const ENTITY_ALIAS = 'p';

    protected function buildQuery(EntityManagerInterface $em): QueryBuilder
    {
        return $em->createQueryBuilder()->select(self::ENTITY_ALIAS)
            ->from(Product::class, self::ENTITY_ALIAS);
    }

    public function byId(int $id): self
    {
        $this->add(function (QueryBuilder $query) use ($id) : void {
            $query->andWhere(sprintf('%s.id = :id', self::ENTITY_ALIAS))
                ->setParameter('id', $id);
        });
        return $this;
    }
}
