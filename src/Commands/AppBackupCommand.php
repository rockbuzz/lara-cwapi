<?php

namespace Rockbuzz\LaraCwApi\Commands;

use Exception;
use Illuminate\Console\Command;

class AppBackupCommand extends Command
{
    protected $signature = 'cw:app-backup';

    protected $description = 'Make backup app';

    public function handle()
    {
        try {
            $operation = app('cloudways')->appManageBackup(
                config('cloudways.server_id'),
                config('cloudways.app_id')
            );
            $this->info("Backup successfully! Operation ID: $operation");

            return 0;
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
