<?php

namespace Ldaidone\LaravelDddCommands;

use Illuminate\Support\ServiceProvider;

class LaravelDddCommandsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ddd-commands.php', 'ddd-commands'
        );
    }

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
