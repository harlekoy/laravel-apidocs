<?php

namespace Harlekoy\ApiDocs\Providers;

use Harlekoy\ApiDocs\ApiDocs;
use Harlekoy\ApiDocs\Commands\ApiDocsInstall;
use Harlekoy\ApiDocs\Commands\ApiRouteListCommand;
use Harlekoy\ApiDocs\Commands\InstallCommand;
use Harlekoy\ApiDocs\Commands\PublishCommand;
use Harlekoy\ApiDocs\Providers\ApiDocsRouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class ApiDocsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResources();

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
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
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        $this->definePublishing();

        // Registering package commands.
        $this->commands([
            ApiDocsInstall::class,
            ApiRouteListCommand::class,
            PublishCommand::class,
        ]);
    }

    /**
     * Register the Totem resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(APIDOCS_PATH.'/resources/views', 'apidocs');
        $this->loadMigrationsFrom(APIDOCS_PATH.'/database/migrations');
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
}
