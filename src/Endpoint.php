<?php

namespace Harlekoy\ApiDocs;

use Harlekoy\ApiDocs\ApiGroup;
use Illuminate\Database\Eloquent\Model;

class Endpoint extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'api_group_id',
        'name',
        'description',
        'method',
        'parameters',
        'sample_response',
        'endpoint',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'parameters'      => 'array',
        'sample_response' => 'array',
    ];


    /**
     * Get endpoint group.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo(ApiGroup::class, 'api_group_id');
    }
}
