<?php

namespace Ldaidone\LaravelDddCommands;

use Illuminate\Support\ServiceProvider;

class LaravelDddCommandsServiceProvider extends ServiceProvider
{
    public function register()
    {
        // If you need bindings, config merges, singletons, etc.
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
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
            // add more as needed
        ]);
    }
    /*
     * @TODO
     * 1. Write tests
     * 2. Build domain folder validator
     * 3. Refactor BaseGenerator
     * 4. Add config file + stub publishing
     * 5. Add Aggregate generator
     * 6. Add CI pipeline
     * 7. Improve README
     * 8. Tag v0.1.0
     *
     */
}
