<?php

namespace Harlekoy\ApiDocs\Http\Middleware;

use Harlekoy\ApiDocs\ApiDocs;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return ApiDocs::check($request) ? $next($request) : abort(403);
    }
}
