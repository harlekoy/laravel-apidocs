<?php

namespace Harlekoy\ApiDocs\Contracts;

use Illuminate\Support\Collection;

interface ApiGroupRepository
{
    /**
     * Return all the API group of a given type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get();

    /**
     * Save the given API group.
     *
     * @param  array $data
     *
     * @return integer
     */
    public function save(array $data);

    /**
     * Store the given API group.
     *
     * @param  array $data
     *
     * @return void
     */
    public function store(array $data);

    /**
     * Return an API group with the given name.
     *
     * @param  mixed  $name
     *
     * @return array
     */
    public function find($name);

    /**
     * Store the given API group updates.
     *
     * @param  array $data
     *
     * @return void
     */
    public function update(array $data);
}
