<?php

namespace App;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Application
{

    public function run(RequestInterface $request): ResponseInterface
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(['box' => null], JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR),
        );
    }

}
