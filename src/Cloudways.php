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
}
