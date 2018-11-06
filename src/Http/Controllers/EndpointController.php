<?php

namespace Betprophet\ApiDocs\Http\Controllers;

use Betprophet\ApiDocs\ApiGroup;
use Betprophet\ApiDocs\Endpoint;
use Betprophet\ApiDocs\Http\Resources\GroupResource;
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
