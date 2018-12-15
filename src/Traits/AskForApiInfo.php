<?php

namespace Harlekoy\ApiDocs\Traits;

trait AskForApiInfo
{
    /**
     * @var string
     */
    protected $prefix = 'api';

    /**
     * @var string
     */
    protected $middleware = 'api';

    /**
     * Ask this question before generating the list of API docs.
     *
     * @return void
     */
    public function asks()
    {
        $options = $this->option();

        // Ask for middleware to filter API routes
        if ($middleware = array_get($options, 'middleware')) {
            $this->middleware = $middleware;
        } else {
            $this->middleware = $this->ask(
                'Enter name to customize the middleware used to generate this doc? Default:', 'api'
            );
        }

        // Ask for the prefix to filter API routes
        if ($prefix = array_get($options, 'prefix')) {
            $this->prefix = $prefix;
        } else {
            $this->prefix = $this->ask('Enter api prefix and version? Default:', 'api');
        }
    }
}