<?php

namespace Yugo\Revue;

use GuzzleHttp\Client;

class Service
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request(string $url, string $method = 'GET', array $payload = []): ?string
    {        
        $response = $this->client->request($method, $url, $payload);

        return (string) $response->getBody();
    }
}

