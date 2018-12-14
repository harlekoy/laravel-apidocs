<?php

use Harlekoy\ApiDocs\Http\Middleware\Authenticate;

return [
    'path' => 'apidocs',

    'name' => 'API Endpoints',

    'version' => 'v1.0.0',

    'url' => env('API_URL'),

    'api_url' => env('API_URL').'/api/v1',

    'group_open' => true,

    'middleware' => [
        'web',
        Authenticate::class,
    ],
];
