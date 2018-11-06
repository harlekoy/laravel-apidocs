<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::get('config', 'ConfigController@index')
    ->name('apidocs.config');

Route::get('endpoints', 'EndpointController@index')
    ->name('apidocs.endpoints');
