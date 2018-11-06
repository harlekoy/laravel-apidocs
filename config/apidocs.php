<?php

use Betprophet\ApiDocs\Http\Middleware\Authenticate;

return [
    'path' => 'apidocs',

    'name' => 'Betprophet API Endpoints',

    'version' => 'v1.0.0',

    'url' => env('APP_URL', '/'),

    'api_url' => env('APP_URL', '/').'/api/v1',

    'group_open' => true,

    'middleware' => [
        'web',
        Authenticate::class,
    ]
];
