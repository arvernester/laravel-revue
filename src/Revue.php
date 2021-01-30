<?php

namespace Yugo\Revue;

use Exception;
use GuzzleHttp\Client;
use InvalidArgumentException;

class Revue
{

    private $server;

    private $token;
    
    private $version;

    public function __construct()
    {
        $this->server = config('revue.server');
        $this->token = config('revue.token');
        $this->version = config('revue.version');

        throw_if(empty($this->token), new Exception('Token for getrevue.io is not set.'));
    }

    private function validateEmail(string $email): void
    {
        throw_if(
            !filter_var($email, FILTER_VALIDATE_EMAIL),
            new InvalidArgumentException(sprintf('Email address %s is invalid.', $email))
        );
    }

    public function version(): string
    {
        return $this->version;
    }

    public function lists(?string $id = null): array
    {
        $path = $id ? sprintf('lists/%s', $id) : 'lists';

        return $this->request($path);
    }

    public function issues(): array
    {
        return $this->request('issues');
    }

    public function subscribers(): array
    {
        return $this->request('subscribers');
    }

    public function subscribe(string $email, array $info = []): array
    {
        $this->validateEmail($email);

        $info['email'] = $email;

        return $this->request('subscribers', 'POST', [
            'form_params' => $info,
        ]);
    }

    public function unsubscribe(string $email, array $info = []): array
    {
        $this->validateEmail($email);

        $info['email'] = $email;

        return $this->request('subscribers/unsubscribe', 'POST', [
            'form_params' => $info,
        ]);
    }

    public function unsubscribed(): array
    {
        return $this->request('subscribers/unsubscribed');
    }

    public function export(?string $id = null)
    {
        $path = $id ? sprintf('exports/%s', $id) : 'exports';

        return $this->request($path);
    }

    public function me(): array
    {
        return $this->request('accounts/me');
    }

    public function request(string $path, string $method = 'GET', array $payload = []): ?array
    {
        $client = new Client([
            'base_uri' => $this->server . '/' . $this->version . '/',
            'headers' => [
                'Authorization' => sprintf('Token %s', $this->token),
            ],
        ]);

        $response = $client->request($method, $path, $payload);

        return json_decode((string) $response->getBody(), true);
    }
}
