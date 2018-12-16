<?php

namespace Harlekoy\ApiDocs\Drivers\File\Repository;

use Harlekoy\ApiDocs\Contracts\ApiGroupRepository as Contract;
use Harlekoy\ApiDocs\Drivers\File\FileStore;
use Illuminate\Http\File;
use Illuminate\Support\Collection;

class FileApiGroupRepository implements Contract
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
        $this->file = $file->setCurrentObject('groups');
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
        $name = array_get($data, 'name');
        $group = $this->find($name);

        if ($group) {
            $this->update(
                array_merge($group, array_except($data, 'name'))
            );

            return $group['id'] ?? null;
        } else {
            return $this->store($data);
        }
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
        return $this->file->push($data);
    }

    /**
     * Return an API group with the given name.
     *
     * @param  mixed  $name
     *
     * @return array
     */
    public function find($name)
    {
        return $this->file
            ->get()
            ->firstWhere('name', $name);
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
                return array_get($item, 'name') === array_get($data, 'name')
                    ? array_merge($item, $data)
                    : $item;
            });

        $this->file->put($content);
    }
}
