<?php

namespace Harlekoy\ApiDocs\Http\Resources;

use Harlekoy\ApiDocs\Http\Resources\EndpointResource;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'endpoints'   => EndpointResource::collection($this->endpoints),
        ];
    }
}
