<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;

class CreateEventCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-event {name}';
    protected $description = 'Create a new DDD event class';

    public function handle()
    {
        $name = $this->argument('name');

        // For now, just echo something to test installation
        $this->info("Event '{$name}' created successfully (placeholder).");

        return Command::SUCCESS;
    }
}