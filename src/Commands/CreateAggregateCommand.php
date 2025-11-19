<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\AggregatedGenerator;

class CreateAggregateCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-aggregate {name}';
    protected $description = 'Create a new DDD aggregate class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $generator = new AggregatedGenerator($name);

        if ($generator->exists($name)) {
            $this->error("Aggregate '{$generator->getAggregatePath()}' already exists.");
            return Command::FAILURE;
        }

        $generator->createAgregateIfStubExists();

        $this->info("Aggregate '{$generator->getAggregatePath()}' created successfully.");
        return Command::SUCCESS;
    }
}