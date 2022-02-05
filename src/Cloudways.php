<?php

namespace Rockbuzz\LaraCwApi;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Cloudways
{
    /** @var string */
    protected $email;

    /** @var string */
    protected $apiKey;

    public function __construct(string $email, string $apiKey)
    {
        $this->email = $email;
        $this->apiKey = $apiKey;
    }

    /**
     * Generate an OAuth access token
     * To access any API call you first need to authorize on our Cloudways API.
     * For the purpose we use OAuth, an open standard for authorization.
     * Here are the steps involved: 1.
     * Get your API Key from here: https://platform.cloudways.com/api 2.
     * Get OAuth Access token using this call. 3.
     * Send the access token with each request in bearer authorization header.
     * Each Access Token will expire after 3600 seconds of inactivity.
     *
     * @param array {email: string, api_key: string} $data
     * @return array {access_token: string, token_type: string, expires_in: int}
     * @throws RequestException
    */
    public function getOAuthAccessToken(): string
    {
        return Cache::remember(
            'cloudways_access_token',
            3600,
            fn () => $this->attempt()['access_token']
        );
    }

    /**
     * Pull repo changes and deploy them
     *
     * @param integer $serverId
     * @param integer $appId
     * @param string $branchName
     * @param string $deployPath
     * @return integer operation_id
    */
    public function startGitPull(
        int $serverId,
        int $appId,
        string $branchName,
        string $deployPath
    ): int {
        $token = $this->getOAuthAccessToken();

        return Http::cloudways()
            ->withToken($token)
            ->post(
                '/git/pull',
                [
                    'server_id' => $serverId,
                    'app_id' => $appId,
                    'branch_name' => $branchName,
                    'deploy_path' => $deployPath
                ]
            )
            ->throw()
            ->json()['operation_id'];
    }

    /**
     * @return array
     */
    private function attempt(): array
    {
        $data = [
            'email' => $this->email,
            'api_key' => $this->apiKey
        ];

        return Http::cloudways()
            ->post('/oauth/access_token', $data)
            ->throw()
            ->json();
    }
}
