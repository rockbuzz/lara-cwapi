<?php

namespace Rockbuzz\LaraCwApi\Commands;

use Exception;
use Illuminate\Console\Command;

class AppBackupCommand extends Command
{
    protected $signature = 'cw:app-backup 
        {server? : The server ID of Cloudways.}
        {app? : The app ID of Cloudways.}';

    protected $description = 'Make backup app';

    public function handle()
    {
        try {

            $operation = app('cloudways')->appManageBackup(
                $this->argument('server') ?? config('cloudways.server_id'),
                $this->argument('app') ?? config('cloudways.app_id')
            );
            $this->info("App Backup successfully!");
            $this->line("Operation ID: $operation");

            return 0;
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
