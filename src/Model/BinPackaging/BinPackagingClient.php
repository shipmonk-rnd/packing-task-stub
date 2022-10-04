<?php
declare(strict_types=1);

namespace App\Model\BinPackaging;

use App\Entity\Packaging;
use App\Entity\Product;
use App\Model\BinPackaging\Exception\BinPackagingException;
use App\Model\HttpClient;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

class BinPackagingClient extends HttpClient
{

    private string $url;

    private string $username;

    private string $apiKey;

    public function __construct(
        $url,
        $username,
        $apiKey
    ) {
        parent::__construct([]);
        $this->url = $url;
        $this->username = $username;
        $this->apiKey = $apiKey;
    }

    /**
     * @param Packaging[] $packings
     * @param Product[] $products
     * @return int
     * @throws BinPackagingException
     * @throws GuzzleException
     */
    public function packAShipmentCall(array $packings, array $products): int
    {
        $response = $this->makeRequest(
            'POST',
            $this->url . '/packer/packIntoMany',
            [
                RequestOptions::BODY => json_encode(
                    [
                        'username' => $this->username,
                        'api_key' => $this->apiKey,
                        'items' => $this->formatItemsFromProducts($products),
                        'bins' => $this->formatBinsFromPackagings($packings),
                    ]
                ),
            ]
        );

        return $this->getPackageIdFromResponse($response);
    }

    /**
     * @throws BinPackagingException
     */
    private function getPackageIdFromResponse(ResponseInterface $response): int
    {
        $responseBodyArray = json_decode((string) $response->getBody(), true);

        if (in_array($response->getStatusCode(), [200, 201], true) === false) {
            throw new \InvalidArgumentException();
        }

        if ((int) $responseBodyArray['response']['status'] === 0) {
            throw new BinPackagingException('Container critical errors');
        }

        $binsPacked = $responseBodyArray['response']['bins_packed'] ?? [];

        if (count($binsPacked) === 0) {
            throw new BinPackagingException('Unable to pack into single box');
        }

        if (count($binsPacked) === 0) {
            throw new BinPackagingException('Unable to pack into box');
        }

        return (int) $binsPacked[0]['bin_data']['id'];
    }

    /**
     * @param Product[] $products
     * @return array<mixed>
     */
    private function formatItemsFromProducts(array $products): array
    {
        return array_map(function (Product $product) {
            return [
                'id' => $product->getId(),
                'w' => $product->getWidth(),
                'h' => $product->getHeight(),
                'd' => $product->getLength(),
                'wg' => $product->getWeight(),
                'q' => 1,
            ];
        }, $products);
    }

    /**
     * @param Packaging[] $packings
     * @return array<mixed>
     */
    private function formatBinsFromPackagings(array $packings): array
    {
        return array_map(function (Packaging $packaging) {
            return [
                'id' => $packaging->getId(),
                'w' => $packaging->getWidth(),
                'h' => $packaging->getHeight(),
                'd' => $packaging->getLength(),
                'max_wg' => $packaging->getMaxWeight(),
            ];
        }, $packings);
    }
}
