<?php

namespace Harlekoy\ApiDocs\Http\Controllers;

use Harlekoy\ApiDocs\ApiGroup;
use Harlekoy\ApiDocs\Endpoint;
use Harlekoy\ApiDocs\Http\Resources\GroupResource;
use Illuminate\Routing\Controller;

class EndpointController extends Controller
{
    public function index()
    {
        $groups = ApiGroup::with('endpoints')
            ->orderBy('name')
            ->get();

        return GroupResource::collection($groups);
    }
}
