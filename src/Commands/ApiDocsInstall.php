<?php

namespace Harlekoy\ApiDocs\Commands;

use Harlekoy\ApiDocs\ApiGroup;
use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Str;

class ApiDocsInstall extends RouteListCommand
{
    use DetectsApplicationNamespace;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apidocs:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install API docs route list';

    /**
     * @var string
     */
    protected $prefix = 'api';

    /**
     * @var string
     */
    protected $middleware = 'api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Router $router)
    {
        parent::__construct($router);

        $this->router = $router;
        $this->routes = $router->getRoutes();
    }

    /**
     * Ask this question before generating the list of API docs.
     *
     * @return void
     */
    public function asks()
    {
        $this->middleware = $this->ask(
            'Enter name to customize the middleware used to generate this doc? Default:', 'api'
        );

        $this->prefix = $this->ask('Enter api prefix and version? Default:', 'api');
    }

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

        $this->comment('Migrating API Docs tables...');
        $this->callSilent('migrate');

        $this->comment('Publishing API Docs Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'apidocs-assets']);

        $this->registerApiDocsConfig();
        $this->registerApiDocsServiceProvider();
        $this->registerApiRouteList();

        $this->info('API Docs scaffolding installed successfully.');
    }

    /**
     * Register API route list.
     *
     * @return void
     */
    public function registerApiRouteList()
    {
        foreach ($this->filterRoutes() as $title => $endpoints) {
            $group = ApiGroup::create([
                'name' => $title,
            ]);

            foreach ($endpoints as $endpoint) {
                $group->endpoints()->create([
                    'method'   => str_replace(['|HEAD', '|PATCH'], '', $endpoint['method']),
                    'endpoint' => $endpoint['uri'],
                ]);
            }
        }

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

    public function filterRoutes()
    {
        return collect($this->getRoutes())
            ->filter(function ($route) {
                $middlewares = explode(
                    ',', array_get($route, 'middleware', '')
                );

                return in_array($this->middleware, $middlewares)
                    && str_contains(array_get($route, 'uri'), $this->prefix);
            })
            ->map(function ($route) {
                $uri = array_get($route, 'uri');

                return array_merge($route, [
                    'uri' => str_replace($this->prefix, '', $uri),
                ]);
            })
            ->groupBy(function ($route) {
                $uri = array_get($route, 'uri');
                $route = preg_replace('/\/\{\w+\}/', '',$uri);
                $fields = array_filter(explode('/', $route));
                $title = implode(' ', $fields);

                return ucfirst($title);
            });
    }
}
