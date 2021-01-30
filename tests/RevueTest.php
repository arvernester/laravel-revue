<?php

namespace Yugo\Revue\Tests;

use Yugo\Revue\Facades\Revue;
use Yugo\Revue\ServiceProvider;
use Orchestra\Testbench\TestCase;

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

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
