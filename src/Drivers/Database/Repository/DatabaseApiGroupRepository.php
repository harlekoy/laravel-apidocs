<?php

namespace Harlekoy\ApiDocs\Drivers\Database\Repository;

use Harlekoy\ApiDocs\Contracts\ApiGroupRepository as Contract;
use Harlekoy\ApiDocs\Drivers\Database\Models\ApiGroup;
use Illuminate\Support\Collection;

class DatabaseApiGroupRepository implements Contract
{
    /**
     * The database connection name that should be used.
     *
     * @var string
     */
    protected $connection;

    /**
     * Create a new database repository.
     *
     * @param  string  $connection
     * @return void
     */
    public function __construct(string $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return all the entries of a given type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return collect(
            ApiGroup::on($this->connection)
                ->orderBy('name')
                ->get()
                ->toArray()
        );
    }

    /**
     * Save the given entries.
     *
     * @param  \Illuminate\Support\Collection $endpoints
     *
     * @return integer
     */
    public function save(array $data)
    {
        $group = ApiGroup::on($this->connection)
            ->firstOrNew(array_only($data, 'name'), $data);

        $group->save();

        return $group->id;
    }

    /**
     * Store the given API group.
     *
     * @param  array $data
     *
     * @return void
     */
    public function store(array $data)
    {
        ApiGroup::on($this->connection)->create($data);
    }

    /**
     * Return an API group with the given id.
     *
     * @param  mixed  $id
     *
     * @return \Harlekoy\ApiDocs\Drivers\Database\Models\ApiGroup
     */
    public function find($id)
    {
        return ApiGroup::on($this->connection)->find($id);
    }

    /**
     * Store the given API group updates.
     *
     * @param  array $data
     *
     * @return void
     */
    public function update(array $data)
    {
        $group = $this->find(array_get($data , 'id'));

        if ($group) {
            $group->fill($data)->save();
        }
    }
}
