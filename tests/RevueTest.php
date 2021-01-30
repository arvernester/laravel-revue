<?php

namespace Yugo\Revue\Tests;

use Yugo\Revue\ServiceProvider;
use Orchestra\Testbench\TestCase;
use Yugo\Revue\Facades\Revue as FacadesRevue;
use Yugo\Revue\Revue;

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
}
