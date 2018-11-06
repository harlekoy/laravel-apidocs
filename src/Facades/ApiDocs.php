<?php

namespace Betprophet\ApiDocs\Facades;

use Illuminate\Support\Facades\Facade;

class ApiDocs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'apidocs';
    }
}
