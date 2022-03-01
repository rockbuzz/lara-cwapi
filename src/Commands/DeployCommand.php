<?php

namespace Rockbuzz\LaraCwApi\Commands;

use Exception;
use Illuminate\Console\Command;

class DeployCommand extends Command
{
    protected $signature = 'cw:deploy {branch?}';

    protected $description = 'Deploy in app via git
        {branch : The branch name of the repository.}';

    public function handle()
    {
        $branch = config('cloudways.git_branch_name');
        $repo = config('cloudways.git_url');

        try {
            $operation = app('cloudways')->startGitPull(
                config('cloudways.server_id'),
                config('cloudways.app_id'),
                $repo,
                $this->argument('branch') ?? $branch,
                config('cloudways.deploy_path')
            );

            $this->info("Deploy successfully!");
            $this->newLine();
            $this->table(
                ['Operation ID', 'Repo', 'Branch'],
                [$operation, $repo, $branch]
            );

            return 0;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return 1;
        }
    }
}
