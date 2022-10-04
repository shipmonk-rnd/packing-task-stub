<?php
declare(strict_types=1);

namespace App\Model;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

abstract class HttpClient extends Client
{

    /**
     * @var string
     */
    protected $httpMethod;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @param string $method
     * @param string $endpoint
     * @param array<mixed> $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    protected function makeRequest(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        $this->endpoint = $endpoint;
        $this->httpMethod = $method;

        return $this->request($method, $endpoint, $options);
    }
}
