<?php

namespace Rockbuzz\LaraCwApi\Commands;

use Exception;
use Illuminate\Console\Command;

class DeployCommand extends Command
{
    protected $signature = 'cw:deploy';

    protected $description = 'Deploy in app via git';

    public function handle()
    {
        try {
            $operation = app('cloudways')->startGitPull(
                config('cloudways.server_id'),
                config('cloudways.app_id'),
                config('cloudways.git_url'),
                config('cloudways.git_branch_name'),
                config('cloudways.deploy_path')
            );
            $this->info("Deploy successfully! Operation ID: $operation");
            return 0;
        } catch (Exception $e) {
            $this->error($e->getMessage());
            return 1;
        }
    }
}
