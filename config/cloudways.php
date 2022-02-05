<?php

return [
    'base_url' => env('CLOUDWAYS_BASE_URL', 'https://api.cloudways.com/api/v1'),
    'email' => env('CLOUDWAYS_EMAIL', 'your@email.com'),
    'api_key' => env('CLOUDWAYS_API_KEY', 'your_api_key'),
    'server_id' => env('CLOUDWAYS_SERVER_ID'),
    'app_id' => env('CLOUDWAYS_APP_ID'),
    'git_url' => env('CLOUDWAYS_GIT_URL'),
    'branch_name' => env('CLOUDWAYS_BRANCH_NAME', 'develop'),
    'deploy_path' => env('CLOUDWAYS_DEPLOY_PATH', '')
];
