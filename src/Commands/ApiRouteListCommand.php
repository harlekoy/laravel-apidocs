<?php

namespace Harlekoy\ApiDocs\Commands;

use Harlekoy\ApiDocs\ApiGroup;
use Harlekoy\ApiDocs\Contracts\ApiEndpointRepository;
use Harlekoy\ApiDocs\Contracts\ApiGroupRepository;
use Harlekoy\ApiDocs\Endpoint;
use Harlekoy\ApiDocs\Traits\AskForApiInfo;
use Illuminate\Foundation\Console\RouteListCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Console\Input\InputOption;

class ApiRouteListCommand extends RouteListCommand
{
    use AskForApiInfo;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'apidocs:routes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered API routes';

    /**
     * @var \Harlekoy\ApiDocs\Contracts\ApiGroupRepository
     */
    protected $group;

    /**
     * @var \Harlekoy\ApiDocs\Contracts\ApiEndpointRepository
     */
    protected $endpoint;

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

        // Repositories
        $this->group = app(ApiGroupRepository::class);
        $this->endpoint = app(ApiEndpointRepository::class);
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->asks();
        $this->registerApiRouteList();
    }

    /**
     * Register API route list.
     *
     * @return void
     */
    public function registerApiRouteList()
    {
        foreach ($this->filterRoutes() as $title => $endpoints) {
            $groupId = $this->group->save(['name' => $title]);

            foreach ($endpoints as $endpoint) {
                $this->endpoint->save([
                    'endpoint'     => $endpoint['uri'],
                    'api_group_id' => $groupId,
                    'method'       => str_replace(['|HEAD', '|PATCH'], '', $endpoint['method']),
                ]);
            }
        }

        Cache::forget('apidocs:endpoints');

        $this->comment('Scafolding API route list...');
    }

    /**
     * Filter routes.
     *
     * @return \Illuminate\Support\Collection
     */
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
                $route = preg_replace('/\/\{\w+\??\}/', '',$uri);
                $fields = array_filter(explode('/', $route));

                $title = implode(' ', $fields);

                return ucfirst($title);
            });
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['middleware', null, InputOption::VALUE_OPTIONAL, 'API middleware'],
            ['prefix', null, InputOption::VALUE_OPTIONAL, 'API prefix'],
        ]);
    }
}
