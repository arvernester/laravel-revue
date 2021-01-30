<?php

namespace Yugo\Revue;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/revue.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('revue.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'revue'
        );

        $this->app->bind('revue', function () {
            return new Revue();
        });
    }
}
