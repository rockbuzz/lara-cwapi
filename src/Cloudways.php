<?php

declare(strict_types=1);

namespace Rockbuzz\LaraCwApi;

use Rockbuzz\LaraCloudways\Api\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

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
    ): int 
    {
        return Http::cloudways()
            ->withToken($this->getAccessToken())
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

    protected function getAccessToken(): string
    {
        $key = config('cloudways.cache_token_key');

        if (Cache::has($key)) return Cache::get($key);

        $token = $this->auth->getOAuthAccessToken();

        return Cache::remember($key, $token->expires, $token->value);
    }
}
