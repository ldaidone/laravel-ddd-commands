<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\UseCaseGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateUseCaseCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-use-case {name}';

    protected $description = 'Create a new DDD UseCase structure';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new UseCaseGenerator($name);

        if ($generator->exists()) {
            $this->error("Use Case {$generator->getUseCasePath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createUseCaseIfStubExists();

        $this->info("Use Case '{$generator->getUseCasePath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
