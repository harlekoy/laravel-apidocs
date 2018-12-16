<?php

namespace Harlekoy\ApiDocs\Drivers\Database\Repository;

use Harlekoy\ApiDocs\Drivers\Database\Models\Endpoint;
use Harlekoy\ApiDocs\Contracts\ApiEndpointRepository as Contract;

class DatabaseApiEndpointRepository implements Contract
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
            Endpoint::on($this->connection)
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
        $endpoint = Endpoint::on($this->connection)
            ->updateOrCreate(array_only($data , 'endpoint'), $data);

        return $endpoint->id;
    }

    /**
     * Store the given API endpoint.
     *
     * @param  array $data
     *
     * @return void
     */
    public function store(array $data)
    {
        Endpoint::on($this->connection)
            ->create($data);
    }

    /**
     * Return an API endpoint with the given id.
     *
     * @param  mixed  $id
     *
     * @return \Harlekoy\ApiDocs\Drivers\Database\Models\Endpoint
     */
    public function find($id)
    {
        return Endpoint::on($this->connection)->find($id);
    }

    /**
     * Store the given API endpoint updates.
     *
     * @param  array $data
     *
     * @return void
     */
    public function update(array $data)
    {
        $endpoint = $this->find(array_get($data, 'id'));

        if ($endpoint) {
            $endpoint->fill($data)->save();
        }
    }
}
