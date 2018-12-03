<?php

namespace Harlekoy\ApiDocs;

use Harlekoy\ApiDocs\Endpoint;
use Harlekoy\ApiDocs\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class ApiGroup extends Model
{
    use Cachable;

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
