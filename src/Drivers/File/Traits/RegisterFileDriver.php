<?php

namespace Harlekoy\ApiDocs\Drivers\File\Traits;

use Harlekoy\ApiDocs\Contracts\ApiEndpointRepository;
use Harlekoy\ApiDocs\Contracts\ApiGroupRepository;
use Harlekoy\ApiDocs\Drivers\File\FileStore;
use Harlekoy\ApiDocs\Drivers\File\Repository\FileApiEndpointRepository;
use Harlekoy\ApiDocs\Drivers\File\Repository\FileApiGroupRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait RegisterFileDriver
{
    /**
     * Register the package file storage driver.
     *
     * @return void
     */
    protected function registerFileDriver()
    {
        $this->app->singleton(
            ApiGroupRepository::class, FileApiGroupRepository::class
        );

        $this->app->singleton(
            ApiEndpointRepository::class, FileApiEndpointRepository::class
        );

        $this->app->when(FileApiGroupRepository::class)
            ->needs('$file')
            ->give($this->getFile());

        $this->app->when(FileApiEndpointRepository::class)
            ->needs('$file')
            ->give($this->getFile());
    }

    /**
     * Get file.
     *
     * @return \Harlekoy\ApiDocs\Drivers\File\FileStore
     */
    protected function getFile()
    {
        return new FileStore();
    }
}