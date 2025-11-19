<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\UseCaseGenerator;

class CreateUseCaseCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-usecase {name}';
    protected $description = 'Create a new DDD UseCase structure';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $generator = new UseCaseGenerator($name);

        if ($generator->exists($name)) {
            $this->error("Use Case {$generator->getUseCasePath()}' already exists.");
            return Command::FAILURE;
        }

        $generator->createUseCaseIfStubExists();

        $this->info("Use Case '{$generator->getUseCasePath()}' created successfully.");
        return Command::SUCCESS;
    }
}