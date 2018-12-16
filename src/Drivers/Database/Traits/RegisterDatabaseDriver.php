<?php

namespace Harlekoy\ApiDocs\Drivers\Database\Traits;

use Harlekoy\ApiDocs\Contracts\ApiEndpointRepository;
use Harlekoy\ApiDocs\Contracts\ApiGroupRepository;
use Harlekoy\ApiDocs\Drivers\Database\Repository\DatabaseApiEndpointRepository;
use Harlekoy\ApiDocs\Drivers\Database\Repository\DatabaseApiGroupRepository;

trait RegisterDatabaseDriver
{
    /**
     * Register the package database storage driver.
     *
     * @return void
     */
    protected function registerDatabaseDriver()
    {
        $this->app->singleton(
            ApiGroupRepository::class, DatabaseApiGroupRepository::class
        );

        $this->app->singleton(
            ApiEndpointRepository::class, DatabaseApiEndpointRepository::class
        );

        $this->app->when(DatabaseApiGroupRepository::class)
            ->needs('$connection')
            ->give(config('apidocs.storage.database.connection'));

        $this->app->when(DatabaseApiEndpointRepository::class)
            ->needs('$connection')
            ->give(config('apidocs.storage.database.connection'));
    }

    /**
     * Register the package's migrations.
     *
     * @return void
     */
    private function registerMigrations()
    {
        if ($this->app->runningInConsole() && $this->shouldMigrate()) {
            $this->loadMigrationsFrom(__DIR__.'../migrations');
        }
    }

    /**
     * Determine if we should register the migrations.
     *
     * @return bool
     */
    protected function shouldMigrate()
    {
        return config('apidocs.driver') === 'database';
    }
}