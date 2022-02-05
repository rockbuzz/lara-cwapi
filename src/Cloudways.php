<?php

namespace Rockbuzz\LaraCwApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class Cloudways
{
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
     * @return integer operation_id
    */
    public function startGitPull(): int 
    {
        $token = $this->getOAuthAccessToken();

        return Http::cloudways()
            ->withToken($token)
            ->post(
                '/git/pull',
                [
                    'server_id' => config('cloudways.server_id'),
                    'app_id' => config('cloudways.app_id'),
                    'git_url' => config('cloudways.git_url'),
                    'branch_name' => config('cloudways.branch_name'),
                    'deploy_path' => config('cloudways.deploy_path')
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
            'email' => config('cloudways.email'),
            'api_key' => config('cloudways.api_key')
        ];

        return Http::cloudways()
            ->post('/oauth/access_token', $data)
            ->throw()
            ->json();
    }
}
