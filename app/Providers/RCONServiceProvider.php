<?php

namespace App\Providers;

use App\PalWorld\RCON\RCON;
use Illuminate\Support\ServiceProvider;

class RCONServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('RCON', function () {
            return new RCON();
        });
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            RCON::class
        ];
    }
}
