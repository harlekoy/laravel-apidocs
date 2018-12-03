<?php

namespace Harlekoy\ApiDocs\Http\Controllers;

use Harlekoy\ApiDocs\ApiGroup;
use Harlekoy\ApiDocs\Endpoint;
use Harlekoy\ApiDocs\Http\Resources\GroupResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class EndpointController extends Controller
{
    public function index()
    {
        $groups = Cache::rememberForever('apidocs:endpoints',
            function () {
                return ApiGroup::with('endpoints')
                    ->orderBy('name')
                    ->get();
            }
        );

        return GroupResource::collection($groups);
    }
}
