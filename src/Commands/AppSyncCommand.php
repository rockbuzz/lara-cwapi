<?php

namespace Rockbuzz\LaraCwApi\Commands;

use Exception;
use Illuminate\Console\Command;

class AppSyncCommand extends Command
{
    protected $signature = 'cw:app-sync
    {from_app_id : Application where you want to deploy your code.}
    {from_server_id? : Server where your application has been deployed.}';

    protected $description = 'Make sync app';

    public function handle()
    {
        try {
            $operation = app('cloudways')->appManageSync(              
                $this->argument('from_app_id'),
                $this->argument('from_server_id') ?? config('cloudways.server_id'),
                config('cloudways.app_id'),
                config('cloudways.server_id'),
            );
            $this->info("App Sync successfully!");
            $this->line("Operation ID: $operation");

            return 0;
        } catch (Exception $e) {
            dd($e);
            $this->error($e->getMessage());
            return 1;
        }
    }
}
