<?php

namespace Chapa\Chapa;

use Illuminate\Support\ServiceProvider;

class ChapaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $config = realpath(__DIR__.'/../config/config.php');
            
            $this->publishes([
                $config => config_path('chapa.php')
            ], 'chapa-config');
        }
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravelchapa');

        // Register the main class to use with the facade
        $this->app->singleton('laravelchapa', function ($app) {
            return new Chapa;
        });

        $this->app->alias('laravelchapa', Chapa::class);
    }

    /**
     * Get the services provided by the provider
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return ['laravelchapa'];
    }
}