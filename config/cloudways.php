<?php

return [
    'base_url' => env('CLOUDWAYS_BASE_URL', 'https://api.cloudways.com/api/v1'),
    'email' => env('CLOUDWAYS_EMAIL', 'your@email.com'),
    'api_key' => env('CLOUDWAYS_API_KEY', 'your_api_key'),
    'cache_token_key' => env('CLOUDWAYS_CACHE_TOKEN_KEY', 'cloudways_access_token'),
];
