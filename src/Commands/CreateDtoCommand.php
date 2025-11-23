<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\DtoGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateDtoCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-dto {name} {--debug}';

    protected $description = 'Create a new DDD Data Transfer Object';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new DtoGenerator($name);

        if ($generator->exists()) {
            $this->error("DTO '{$generator->getDtoPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createDtoIfStubExists();

        $this->info("DTO '{$generator->getDtoPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
