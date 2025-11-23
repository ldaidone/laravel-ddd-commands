<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\AggregatedGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateAggregateCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-aggregate {name}';

    protected $description = 'Create a new DDD aggregate class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new AggregatedGenerator($name);

        if ($generator->exists()) {
            $this->error("Aggregate '{$generator->getAggregatePath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createAgregateIfStubExists();

        $this->info("Aggregate '{$generator->getAggregatePath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
