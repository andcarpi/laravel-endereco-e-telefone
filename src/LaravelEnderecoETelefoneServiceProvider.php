<?php

namespace andcarpi\LaravelEnderecoETelefone;

use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedAll;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedBrazilianCities;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedBrazilianStates;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedCountriesApiLocalidades;
use andcarpi\LaravelEnderecoETelefone\Console\Commands\SeedCountriesApiPaises;
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
                SeedCountriesApiPaises::class,
                SeedBrazilianStates::class,
                SeedBrazilianCities::class,
                SeedCountriesApiLocalidades::class,
            ]);
        }
    }

    private function getMigrationsPath()
    {
        return __DIR__.'/../database/migrations/';
    }
}
