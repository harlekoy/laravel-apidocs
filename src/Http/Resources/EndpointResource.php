<?php

namespace Harlekoy\ApiDocs\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EndpointResource extends JsonResource
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
            'id'              => $this->id,
            'endpoint'        => $this->endpoint,
            'method'          => $this->method,
            'description'     => $this->description,
            'parameters'      => $this->parameters,
            'sample_response' => $this->sample_response,
        ];
    }
}
