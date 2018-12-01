<?php

namespace Harlekoy\ApiDocs;

use Harlekoy\ApiDocs\Endpoint;
use Illuminate\Database\Eloquent\Model;

class ApiGroup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get group API endpoints.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function endpoints()
    {
        return $this->hasMany(Endpoint::class);
    }
}
