<?php

namespace Harlekoy\ApiDocs\Traits;

use Illuminate\Support\Facades\Cache;

trait Cachable
{
    /**
     * Boot cachable.
     */
    protected static function bootCachable()
    {
        static::saved(function ($model) {
            Cache::forget('apidocs:endpoints');
        });
    }
}