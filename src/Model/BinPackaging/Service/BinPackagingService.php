<?php
declare(strict_types=1);

namespace App\Model\BinPackaging\Service;

use App\Entity\Packaging;
use App\Entity\Product;
use App\Model\BinPackaging\BinPackagingClient;
use App\Model\BinPackaging\Exception\BinPackagingException;
use GuzzleHttp\Exception\GuzzleException;

class BinPackagingService
{
    private BinPackagingClient $binPackagingClient;

    public function __construct(BinPackagingClient $binPackagingClient)
    {
        $this->binPackagingClient = $binPackagingClient;
    }

    /**
     * @param Product[] $products
     * @param Packaging[] $packings
     * @return int
     * @throws BinPackagingException
     * @throws GuzzleException
     */
    public function findBestPacking(array $products, array $packings): int
    {
        return $this->binPackagingClient->packAShipmentCall($packings, $products);
    }
}
