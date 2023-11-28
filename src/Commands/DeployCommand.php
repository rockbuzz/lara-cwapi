<?php

namespace Rockbuzz\LaraCwApi\Commands;

use Exception;
use Illuminate\Console\Command;

class DeployCommand extends Command
{
    protected $signature = 'cw:deploy 
        {branch? : The branch name of the repository.}
        {app? : The app ID of Cloudways.}
        {server? : The server ID of Cloudways.}';

    protected $description = 'Deploy in app via git';

    public function handle()
    {
        $repo = config('cloudways.git_url');

        try {
            $operation = app('cloudways')->startGitPull(
                $server = $this->argument('server') ?? config('cloudways.server_id'),
                $app = $this->argument('app') ?? config('cloudways.app_id'),
                $repo,
                $branch = $this->argument('branch') ?? config('cloudways.git_branch_name'),
                config('cloudways.deploy_path')
            );

            $this->info("Deploy successfully!");
            $this->line("Operation ID: $operation");
            $this->line("Repository: $repo");
            $this->line("Branch: $branch");
            $this->line("App: $app");
            $this->line("Server: $server");

            return 0;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return 1;
        }
    }
}
