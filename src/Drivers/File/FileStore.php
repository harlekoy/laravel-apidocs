<?php

namespace Harlekoy\ApiDocs\Drivers\File;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Webpatser\Uuid\Uuid;

class FileStore
{
    /**
     * @var string
     */
    protected $currentObject;

    /**
     * Get JSON path.
     *
     * @return string
     */
    public function path()
    {
        return config('apidocs.storage.file.path').'.json';
    }

    /**
     * Get content.
     *
     * @return array|StdClass
     */
    public function content()
    {
        $path = $this->path();

        if (!File::exists($path)) {
            File::put($path, '{}');
        }

        $object = json_decode(File::get($path), true);

        if ($this->currentObject) {
            return array_get($object, $this->currentObject, []);
        }

        return $object;
    }

    /**
     * Get full content.
     *
     * @return array
     */
    public function fullContent()
    {
        $current = $this->currentObject;
        $content = $this->setCurrentObject(null)->content();
        $this->setCurrentObject($current);

        return $content;
    }

    /**
     * Get content as collection.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return collect($this->content());
    }

    /**
     * Collection push.
     *
     * @param  array  $item
     *
     * @return void
     */
    public function push(array $item)
    {
        $id = Uuid::generate()->string;
        $content = $this->get()->push(array_merge($item, compact('id')));

        $this->put($content);

        return $id;
    }

    /**
     * File put content.
     *
     * @param  Collection $content
     *
     * @return void
     */
    public function put(Collection $content)
    {
        $full = $this->fullContent();
        $full[$this->currentObject] = $content;

        File::put($this->path(), collect($full)->toJson(JSON_PRETTY_PRINT));
    }

    /**
     * Set current object accessing.
     *
     * @param string $name
     */
    public function setCurrentObject($name)
    {
        $this->currentObject= $name;

        return $this;
    }
}