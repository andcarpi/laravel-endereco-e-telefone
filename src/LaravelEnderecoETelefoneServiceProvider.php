<?php

namespace andcarpi\LaravelEnderecoETelefone;

use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedAll;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedBrazilianCities;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedBrazilianStates;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedCountries;
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

    private function publishMigrations()
    {
        $path = $this->getMigrationsPath();
        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom($this->getMigrationsPath());

        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedAll::class,
                SeedCountries::class,
                SeedBrazilianStates::class,
                SeedBrazilianCities::class,
            ]);
        }
    }

    private function getMigrationsPath()
    {
        return __DIR__.'/../database/migrations/';
    }
}
