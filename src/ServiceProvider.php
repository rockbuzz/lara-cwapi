<?php

namespace Rockbuzz\LaraCwApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider as SupportServiceProvider;
use Rockbuzz\LaraCwApi\Commands\AppBackupCommand;
use Rockbuzz\LaraCwApi\Commands\DeployCommand;

class ServiceProvider extends SupportServiceProvider
{

    public function boot(Filesystem $filesystem)
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/cloudways.php' => config_path('cloudways.php')
            ], 'config');
        }

        $this->app->bind(
            'cloudways',
            function () {
                return new Cloudways(
                    new Auth(config('cloudways.email'), config('cloudways.api_key'))
                );
            }
        );

        Http::macro(
            'cloudways',
            function () {
                return Http::baseUrl(config('cloudways.base_url'));
            }
        );

        $this->commands([
            DeployCommand::class,
            AppBackupCommand::class
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cloudways.php', 'cloudways');
    }
}
