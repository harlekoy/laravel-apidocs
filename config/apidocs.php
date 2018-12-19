<?php

use Harlekoy\ApiDocs\Http\Middleware\Authenticate;

return [

    /*
    |--------------------------------------------------------------------------
    | API Docs Path
    |--------------------------------------------------------------------------
    |
    | This is the URI path where API Docs will be accessible from. Feel free to
    | change this path to anything you like. Note that this URI will not
    | affect API Docs' internal API routes which aren't exposed to users.
    |
    */

    'path' => '/apidocs',

    /*
    |--------------------------------------------------------------------------
    | API Display Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application's API. This value is used when the
    | framework needs to display the name of the application within the UI
    | or in other locations. Of course, you're free to change the value.
    |
    */

    'name' => 'API Endpoints',

    'version' => 'v1.0.0',

    /*
    |--------------------------------------------------------------------------
    | Docs API Base URL
    |--------------------------------------------------------------------------
    |
    | This URL is where users will be the base URL for the API to request from.
    | You are free to change this URL to any location you wish depending on
    | the needs of your API.
    |
    */

    'url' => env('API_URL'),

    'api_url' => env('API_URL').'/api/v1',

    'group_open' => true,

    /*
    |--------------------------------------------------------------------------
    | API Docs Route Middleware
    |--------------------------------------------------------------------------
    |
    | These middleware will be assigned to every API Docs route, giving you the
    | chance to add your own middleware to this stack or override any of
    | the existing middleware. Or, you can just stick with this stack.
    |
    */

    'middleware' => [
        'web',
        Authenticate::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | API Docs Storage Driver
    |--------------------------------------------------------------------------
    |
    | This configuration options determines the storage driver that will
    | be used to store API docs data. In addition, you may set any
    | custom options as needed by the particular driver you choose.
    |
    | Supported: "file", "database"
    |
    */

    'driver' => env('APIDOCS_DRIVER', 'file'),

    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
        'file' => [
            'path' => storage_path('app/apidocs'),
        ],
    ],
];
