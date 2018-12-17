<?php

namespace Harlekoy\ApiDocs\Commands;

use Harlekoy\ApiDocs\ApiGroup;
use Harlekoy\ApiDocs\Drivers\Database\Traits\RegisterDatabaseDriver;
use Harlekoy\ApiDocs\Traits\AskForApiInfo;
use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\Str;

class ApiDocsInstall extends Command
{
    use DetectsApplicationNamespace, AskForApiInfo, RegisterDatabaseDriver;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apidocs:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install API docs route list';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->asks();

        $this->comment('Publishing API Docs Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'apidocs-provider']);

        if ($this->shouldMigrate()) {
            $this->comment('Migrating API Docs tables...');
            $this->callSilent('migrate');
        }

        $this->comment('Publishing API Docs Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'apidocs-assets']);

        $this->registerApiDocsConfig();
        $this->registerApiDocsServiceProvider();
        $this->registerApiRoutes();

        $this->info('API Docs scaffolding installed successfully.');
    }

    /**
     * Register API routes.
     *
     * @return void
     */
    public function registerApiRoutes()
    {
        $this->callSilent('apidocs:routes', [
            '--middleware' => $this->middleware,
            '--prefix'     => $this->prefix,
        ]);

        $this->comment('Scafolding API route list...');
    }

    /**
     * Register API Docs configuration.
     *
     * @return void
     */
    public function registerApiDocsConfig()
    {
        $this->comment('Publishing API Docs Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'apidocs-config']);

        $config = file_get_contents(config_path('apidocs.php'));

        if (!Str::contains($config, "'/api/v1'")) {
            return;
        }

        $version = trim($this->prefix, '/');

        file_put_contents(config_path('apidocs.php'), str_replace(
            "'/api/v1'",
            "'/{$version}'",
            $config
        ));
    }

    /**
     * Register the API Docs service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerApiDocsServiceProvider()
    {
        $namespace = str_replace_last('\\', '', $this->getAppNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\ApiDocsServiceProvider::class')) {
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\ApiDocsServiceProvider::class,".PHP_EOL,
            $appConfig
        ));

        file_put_contents(app_path('Providers/ApiDocsServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/ApiDocsServiceProvider.php'))
        ));
    }
}
