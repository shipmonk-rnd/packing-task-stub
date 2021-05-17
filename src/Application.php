<?php

namespace App;

use App\Entity\Packaging;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{

    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function run(RequestInterface $request): ResponseInterface
    {
        $boxes = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from(Packaging::class, 'p')
            ->getQuery()
            ->getResult();

        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['boxes' => count($boxes)], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
        );
    }

}
