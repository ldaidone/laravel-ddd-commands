<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateEventCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-event {name}';

    protected $description = 'Create a new DDD event class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new \Ldaidone\LaravelDddCommands\Generators\EventGenerator($name);

        if ($generator->exists()) {
            $this->error("Event '{$generator->getEventPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createEventIfStubExists();

        $this->info("Event '{$generator->getEventPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
