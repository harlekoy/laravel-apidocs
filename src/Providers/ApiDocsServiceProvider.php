<?php

namespace Harlekoy\ApiDocs\Providers;

use Harlekoy\ApiDocs\ApiDocs;
use Harlekoy\ApiDocs\Commands\ApiDocsInstall;
use Harlekoy\ApiDocs\Commands\ApiRouteListCommand;
use Harlekoy\ApiDocs\Commands\InstallCommand;
use Harlekoy\ApiDocs\Commands\PublishCommand;
use Harlekoy\ApiDocs\Drivers\Database\Traits\RegisterDatabaseDriver;
use Harlekoy\ApiDocs\Drivers\File\Traits\RegisterFileDriver;
use Harlekoy\ApiDocs\Providers\ApiDocsRouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class ApiDocsServiceProvider extends ServiceProvider
{
    use RegisterDatabaseDriver,
        RegisterFileDriver;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();
        $this->registerMigrations();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->definePublishing();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('APIDOCS_PATH')) {
            define('APIDOCS_PATH', realpath(__DIR__.'/../../'));
        }

        $this->app->register(ApiDocsRouteServiceProvider::class);

        $this->mergeConfigFrom(APIDOCS_PATH.'/config/apidocs.php', 'apidocs');

        // Register the service the package provides.
        $this->app->singleton('apidocs', function ($app) {
            return new ApiDocs;
        });

        $this->registerStorageDriver();

        // Registering package commands.
        $this->commands([
            ApiDocsInstall::class,
            ApiRouteListCommand::class,
            PublishCommand::class,
        ]);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['apidocs'];
    }

    /**
     * Register the Totem resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(APIDOCS_PATH.'/resources/views', 'apidocs');
    }

    /**
     * Define the publishing configuration.
     *
     * @return void
     */
    public function definePublishing()
    {
        $this->publishes([
            APIDOCS_PATH.'/public/vendor/apidocs/js' => public_path('vendor/apidocs/js'),
        ], 'apidocs-assets');

        $this->publishes([
            APIDOCS_PATH.'/public/vendor/apidocs/css' => public_path('vendor/apidocs/css'),
        ], 'apidocs-assets');

        $this->publishes([
            APIDOCS_PATH.'/public/vendor/apidocs/img' => public_path('vendor/apidocs/img'),
        ], 'apidocs-assets');

        $this->publishes([
            APIDOCS_PATH.'/config/apidocs.php' => config_path('apidocs.php'),
        ], 'apidocs-config');

        $this->publishes([
            APIDOCS_PATH.'/stubs/ApiDocsServiceProvider.stub' => app_path('Providers/ApiDocsServiceProvider.php'),
        ], 'apidocs-provider');
    }

    /**
     * Register the package storage driver.
     *
     * @return void
     */
    protected function registerStorageDriver()
    {
        $driver = config('apidocs.driver');

        if (method_exists($this, $method = 'register'.ucfirst($driver).'Driver')) {
            $this->$method();
        }
    }
}
