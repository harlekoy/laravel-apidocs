<?php

namespace Harlekoy\ApiDocs\Commands;

use Harlekoy\ApiDocs\ApiGroup;
use Illuminate\Console\Command;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class ApiDocsInstall extends RouteListCommand
{
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
    protected $prefix = 'api/v1';

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

        $this->prefix = $this->ask('Enter api prefix and version? Default:', 'api/v1');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->asks();

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
    }

    public function filterRoutes()
    {
        return collect($this->getRoutes())
            ->filter(function ($route) {
                $middlewares = explode(
                    ',', array_get($route, 'middleware', '')
                );

                return in_array($this->middleware, $middlewares)
                    && str_contains(array_get($route, 'uri'), 'api/v1');
            })
            ->map(function ($route) {
                $uri = array_get($route, 'uri');

                return array_merge($route, [
                    'uri' => str_replace('api/v1', '', $uri),
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
