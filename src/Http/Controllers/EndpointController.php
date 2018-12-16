<?php

namespace Harlekoy\ApiDocs\Http\Controllers;

use Harlekoy\ApiDocs\ApiGroup;
use Harlekoy\ApiDocs\Contracts\ApiEndpointRepository;
use Harlekoy\ApiDocs\Contracts\ApiGroupRepository;
use Harlekoy\ApiDocs\Endpoint;
use Harlekoy\ApiDocs\Http\Resources\GroupResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class EndpointController extends Controller
{
    /**
     * List the API endpoints with there respected groups.
     *
     * @param  \Harlekoy\ApiDocs\Contracts\ApiEndpointRepository  $storage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ApiGroupRepository $group, ApiEndpointRepository $endpoint)
    {
        $groups = Cache::rememberForever('apidocs:endpoints',
            function () use ($group, $endpoint) {
                return $group->get()
                    ->map(function ($data) use ($endpoint) {
                        return array_merge($data, [
                            'endpoints' => $endpoint->get()
                                ->where('api_group_id', $data['id'])
                        ]);
                    });
            }
        );

        return response()->json(['data' => $groups]);
    }
}
