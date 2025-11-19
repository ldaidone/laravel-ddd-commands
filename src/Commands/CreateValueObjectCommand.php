<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\ValueObjectGenerator;

class CreateValueObjectCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-value-object {name}';
    protected $description = 'Create a new DDD valueObject class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $generator = new ValueObjectGenerator($name);

        if ($generator->exists($name)) {
            $this->error("Entity '{$generator->getValueObjectPath()}' already exists.");
            return Command::FAILURE;
        }

        $generator->createValueObjectIfStubExists();

        $this->info("Entity '{$generator->getValueObjectPath()}' created successfully.");
        return Command::SUCCESS;
    }
}