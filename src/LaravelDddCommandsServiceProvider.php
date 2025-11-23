<?php

namespace Ldaidone\LaravelDddCommands;

use Illuminate\Support\ServiceProvider;

/**
 * Service provider for the Laravel DDD Commands package.
 *
 * This service provider registers all artisan commands provided by the package
 * and handles the publishing of configuration and stub files.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class LaravelDddCommandsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * Merges the package configuration with the application's published configuration.
     * If no published configuration exists, it uses the default configuration from the package.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ddd-commands.php', 'ddd-commands'
        );
    }

    /**
     * Bootstrap the application services.
     *
     * Registers package commands when the application is running in console mode
     * and sets up the publishing of configuration and stub files.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->publishes([
                __DIR__.'/../config/ddd-commands.php' => config_path('ddd-commands.php'),
            ], 'ddd-commands-config');

            $this->publishes([
                __DIR__.'/../stubs/ddd' => resource_path('stubs/ddd-commands'),
            ], 'ddd-commands-stubs');
        }
    }

    /**
     * Register all the package commands.
     *
     * This method registers all artisan commands provided by the package
     * with Laravel's command container for use in the console.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands([
            Commands\CreateDomainCommand::class,
            Commands\CreateUseCaseCommand::class,
            Commands\CreateEntityCommand::class,
            Commands\CreateValueObjectCommand::class,
            Commands\CreateRepositoryCommand::class,
            Commands\CreateEventCommand::class,
            Commands\CreateAggregateCommand::class,
            Commands\CreateDtoCommand::class,
            Commands\CreateActionCommand::class,
            Commands\CreateCommandCommand::class,
            Commands\CreateQueryCommand::class,
            // add more as needed
        ]);
    }
}
