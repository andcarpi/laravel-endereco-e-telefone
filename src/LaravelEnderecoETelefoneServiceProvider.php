<?php

namespace Andcarpi\LaravelEnderecoETelefone;

use Andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedCountries;
use Illuminate\Support\ServiceProvider;

class LaravelEnderecoETelefoneServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedCountries::class,
            ]);
        }
    }
}
