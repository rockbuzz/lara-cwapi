<?php

return [
    'base_url' => env('CLOUDWAYS_BASE_URL', 'https://api.cloudways.com/api/v1'),
    'email' => env('CLOUDWAYS_EMAIL', ''),
    'api_key' => env('CLOUDWAYS_API_KEY', ''),
    'server_id' => env('DEPLOY_SERVER_ID'),
    'app_id' => env('DEPLOY_APP_ID'),
    'git_url' => env('DEPLOY_GIT_URL'),
    'branch_name' => env('DEPLOY_BRANCH_NAME', 'develop'),
    'deploy_path' => env('DEPLOY_PATH', '')
];
