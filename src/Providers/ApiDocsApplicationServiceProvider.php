<?php

namespace Harlekoy\ApiDocs\Providers;

use Harlekoy\ApiDocs\Facades\ApiDocs;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ApiDocsApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->authorization();
    }

    /**
     * Configure the Telescope authorization services.
     *
     * @return void
     */
    protected function authorization()
    {
        $this->gate();

        ApiDocs::auth(function ($request) {
            return app()->environment('local') ||
                   Gate::check('viewApiDocs', [$request->user()]);
        });
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewApiDocs', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
