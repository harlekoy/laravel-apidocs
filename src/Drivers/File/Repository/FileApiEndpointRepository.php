<?php

namespace Harlekoy\ApiDocs\Drivers\File\Repository;

use Harlekoy\ApiDocs\Contracts\ApiEndpointRepository as Contract;
use Harlekoy\ApiDocs\Drivers\File\FileStore;
use Illuminate\Support\Collection;

class FileApiEndpointRepository implements Contract
{
    /**
     * @var \Harlekoy\ApiDocs\Drivers\File\FileStore
     */
    protected $file;

    /**
     * Create a new database repository.
     *
     * @param  \Harlekoy\ApiDocs\Drivers\File\FileStore  $file
     * @return void
     */
    public function __construct(FileStore $file)
    {
        $this->file = $file->setCurrentObject('endpoints');
    }

    /**
     * Return all the entries of a given type.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->file->get();
    }

    /**
     * Save the given entries.
     *
     * @param  \Illuminate\Support\Collection $endpoints
     *
     * @return boolean
     */
    public function save(array $data)
    {
        $endpoint = $this->find(array_only($data, [
            'endpoint', 'method',
        ]));

        if ($endpoint) {
            $this->update(array_merge($endpoint, $data));
        } else {
            $this->store($data);
        }
    }

    /**
     * Get the API group title.
     *
     * @param  array $endpoint
     *
     * @return string
     */
    protected function title($endpoint)
    {
        $uri = array_get($endpoint, 'endpoint');
        $route = preg_replace('/\/\{\w+\}/', '',$uri);
        $fields = array_filter(explode('/', $route));
        $title = implode(' ', $fields);

        return ucfirst($title);
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
        $this->file->push($data);
    }

    /**
     * Return an API group with the given name.
     *
     * @param  array  $attributes
     *
     * @return array
     */
    public function find($attributes)
    {
        return $this->file
            ->get()
            ->where('endpoint', array_get($attributes, 'endpoint'))
            ->where('method', array_get($attributes, 'method'))
            ->first();
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
        $content = $this->file
            ->get()
            ->transform(function ($item) use ($data) {
                return array_get($item, 'endpoint') === array_get($data, 'endpoint') ||
                    array_get($item, 'method') === array_get($data, 'method')
                    ? array_merge($item, $data)
                    : $item;
            });

        $this->file->put($content);
    }

    /**
     * Update endpoint.
     *
     * @param  array $endpoints
     * @param  array $data
     *
     * @return \Illuminate\Support\Collection
     */
    protected function updateEndpoint($endpoints, $data)
    {
        return collect($endpoints)
            ->transform(function ($item) use ($data) {
                return array_get($item, 'endpoint') === array_get($data, 'endpoint') ||
                    array_get($item, 'method') === array_get($data, 'method')
                    ? array_merge($item, $data)
                    : $item;
            });
    }
}
