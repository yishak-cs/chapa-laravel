<?php

namespace Chapa\ChapaLaravel;

use Illuminate\Support\ServiceProvider;

class ChapaLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $config = realpath(__DIR__.'/../config/config.php');

            $this->publishes([
                $config => config_path('chapa.php')
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'chapa-laravel');

        // Register the main class to use with the facade
        $this->app->singleton('chapa-laravel', function () {
            return new ChapaLaravel;
        });

        $this->app->alias('laravelchapa', "Chapa\ChapaLaravel\ChapaLaravel");

    }

    /**
    * Get the services provided by the provider
    *
    * @return array
    */
    public function provides()
    {
        return ['laravelchapa'];
    }
}
