<?php

namespace Rockbuzz\LaraCwApi;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use Rockbuzz\LaraCloudways\Api\Auth;

class ServiceProvider extends SupportServiceProvider
{

    public function boot(Filesystem $filesystem)
    {
        $this->publishes([
            __DIR__ . '/../config/cloudways.php' => config_path('cloudways.php')
        ], 'config');

        $this->app->bind(
            'cloudways', 
            fn () => new Cloudways(
                new Auth(config('cloudways.email'), config('cloudways.api_key'))
            )   
        );

        Http::macro('cloudways', fn () => Http::baseUrl(config('cloudways.base_url')));
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cloudways.php', 'cloudways');
    }
}
