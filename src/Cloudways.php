<?php

declare(strict_types=1);

namespace Rockbuzz\LaraCwApi;

use Illuminate\Support\Facades\Http;

class Cloudways
{
    /** @var Auth */
    protected $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    /**
     * Pull repo changes and deploy them
     *
     * @param integer $server
     * @param integer $app
     * @param string $git
     * @param string $branch
     * @param string $path
     * @return integer Opreation ID
     * @throws RequestException
     */
    public function startGitPull(
        int $server,
        int $app,
        string $git,
        string $branch,
        string $path = ''
    ): int {
        $token = $this->auth->getOAuthAccessToken();

        return Http::cloudways()
            ->withToken($token->value)
            ->post(
                '/git/pull',
                [
                    'server_id' => $server,
                    'app_id' => $app,
                    'git_url' => $git,
                    'branch_name' => $branch,
                    'deploy_path' => $path
                ]
            )
            ->throw()
            ->json()['operation_id'];
    }

    /**
     * Take application backup
     *
     * @param integer $server
     * @param integer $app
     * @return integer Opreation ID
     * @throws RequestException
     */
    public function appManageBackup(int $server, int $app): int
    {
        $token = $this->auth->getOAuthAccessToken();

        return Http::cloudways()
            ->withToken($token->value)
            ->post(
                '/app/manage/takeBackup',
                [
                    'server_id' => $server,
                    'app_id' => $app
                ]
            )
            ->throw()
            ->json()['operation_id'];
    }

    /**
     * Take application backup
     *
     * @param integer $server
     * @param integer $app
     * @return integer Opreation ID
     * @throws RequestException
     */
    public function appManageSync(
        int $sourceApp,
        int $sourceServer,
        int $app,
        int $server,
        string $action = 'pull',
        bool $appFiles = false,
        bool $dbFiles = true,
        bool $backupTable = true,
        bool $backup = true
    ) {
        $token = $this->auth->getOAuthAccessToken();

        return Http::cloudways()
            ->withToken($token->value)
            ->post(
                '/sync/app',
                [
                    'source_server_id' => $sourceServer,
                    'source_app_id' => $sourceApp,
                    'action' => $action,
                    'appFiles' => $appFiles,
                    'dbFiles' => $dbFiles,
                    'table' => $backupTable,
                    'app_id' => $app,
                    'server_id' => $server,
                    'backup' => $backup
                ]
            )
            ->throw()
            ->json()['operation_id'];
    }
}
