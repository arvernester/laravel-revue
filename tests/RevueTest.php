<?php

namespace Yugo\Revue\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Yugo\Revue\ServiceProvider;
use Orchestra\Testbench\TestCase;
use Yugo\Revue\Facades\Revue;
use Yugo\Revue\Service;

class RevueTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'revue' => Revue::class,
        ];
    }

    private function mockHttp(array $response): Client
    {
        $stack = HandlerStack::create(new MockHandler($response));
        
        return new Client(['handler' => $stack]);
    }

    public function testMe(): void
    {
        $expectation = ['profile_id' => 'https://www.getrevue.co/profile/getrevue'];
        $http = $this->mockHttp([new Response(200, [], json_encode($expectation))]);

        $response = (new Service($http))->request('accounts/me');

        Revue::shouldReceive('me')
            ->once()
            ->andReturn($expectation);

        $this->assertSame(Revue::me(), json_decode($response, true));
    }
}
