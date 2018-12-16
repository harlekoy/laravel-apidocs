<?php

namespace Harlekoy\ApiDocs\Contracts;

use Illuminate\Support\Collection;

interface ApiEndpointRepository
{
    /**
     * Return all the API endpoint of a given type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get();

    /**
     * Save the given API endpoint.
     *
     * @param  array $data
     *
     * @return integer
     */
    public function save(array $data);

    /**
     * Store the given API endpoint.
     *
     * @param  array $data
     *
     * @return void
     */
    public function store(array $data);

    /**
     * Return an API endpoint with the given name.
     *
     * @param  mixed  $name
     *
     * @return array
     */
    public function find($name);

    /**
     * Store the given API endpoint updates.
     *
     * @param  array $data
     *
     * @return void
     */
    public function update(array $data);
}
