<?php

return [
    'base_url' => env('CLOUDWAYS_BASE_URL', 'https://api.cloudways.com/api/v1'),
    'email' => env('CLOUDWAYS_EMAIL', ''),
    'api_key' => env('CLOUDWAYS_API_KEY', ''),
    'server_id' => env('CLOUDWAYS_SERVER_ID'),
    'app_id' => env('CLOUDWAYS_APP_ID'),
    'git_url' => env('CLOUDWAYS_GIT_URL'),
    'git_branch_name' => env('CLOUDWAYS_GIT_BRANCH_NAME', 'develop'),
    'deploy_path' => env('CLOUDWAYS_DEPLOY_PATH', '')
];
