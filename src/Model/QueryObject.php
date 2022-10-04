<?php
declare(strict_types=1);

namespace App\Model;

use App\Entity\BaseEntity;
use Closure;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

abstract class QueryObject
{

    protected const ENTITY_ALIAS = 's';

    /**
     * @var Closure[]
     */
    private array $modifiers = [];

    /**
     * @var Closure[]
     */
    private array $postFetch = [];

    public static function create(Closure $filter = null): self
    {
        $query = new static();

        if ($filter !== null) {
            $filter($query);
        }

        return $query;
    }

    final public function __construct()
    {
    }

    public function limit(?int $limit, int $offset = null): self
    {
        return $this->add(static function (QueryBuilder $qb) use ($limit, $offset) {
            $qb->setMaxResults($limit);
            if ($offset !== null) {
                $qb->setFirstResult($offset);
            }
        });
    }

    /**
     * @param EntityManagerInterface $em
     * @return BaseEntity[]
     */
    public function fetch(EntityManagerInterface $em): array
    {
        /** @var BaseEntity[] $result */
        $result = $this->getQuery($em)->getResult();
        $this->applyPostFetch($em, $result);

        return $result;
    }

    public function fetchOne(EntityManagerInterface $em): ?BaseEntity
    {
        $result = $this->limit(1)->fetch($em);

        return reset($result) ?: null;
    }

    abstract protected function buildQuery(EntityManagerInterface $em): QueryBuilder;

    protected function add(Closure $modifier): self
    {
        $this->modifiers[] = $modifier;

        return $this;
    }

    protected function applyModifiers(QueryBuilder $queryBuilder): QueryBuilder
    {
        foreach ($this->modifiers as $modifier) {
            $modifier($queryBuilder);
        }

        return $queryBuilder;
    }

    protected function addPostFetch(Closure $listener): self
    {
        $this->postFetch[] = $listener;

        return $this;
    }

    /**
     * @param EntityManagerInterface $em
     * @param BaseEntity[] $result
     * @return void
     */
    protected function applyPostFetch(EntityManagerInterface $em, array $result): void
    {
        if ($result === []) {
            return;
        }

        foreach ($this->postFetch as $listener) {
            $listener($em, $result);
        }
    }

    protected function getQuery(EntityManagerInterface $em, Closure $modifier = null): Query
    {
        $queryBuilder = $this->applyModifiers($this->buildQuery($em));

        if ($modifier !== null) {
            $modifier($queryBuilder);
        }

        return $queryBuilder->getQuery();
    }
}
