<?php

namespace Yugo\Revue\Facades;

use Illuminate\Support\Facades\Facade;

class Revue extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'revue';
    }
}
