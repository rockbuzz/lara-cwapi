<?php

namespace Rockbuzz\LaraCwApi;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class Auth
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
     * @return Token
     * @throws RequestException
    */
    public function getOAuthAccessToken(): Token
    {
        return Token::fromArray(
            Http::cloudways()
                ->post(
                    '/oauth/access_token',
                    [
                        'email' => $this->email,
                        'api_key' => $this->apiKey
                    ]
                )
                ->throw()
                ->json()
        );
    }
}
