<?php

namespace App\Providers;

use App\Gameserver\Communication\Rcon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind('Rcon', function() {
            return new Rcon();
        });
    }
}
