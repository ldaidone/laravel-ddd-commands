<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\ValueObjectGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateValueObjectCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-value-object {name} {--debug}';

    protected $description = 'Create a new DDD valueObject class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new ValueObjectGenerator($name);

        if ($generator->exists()) {
            $this->error("Entity '{$generator->getValueObjectPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createValueObjectIfStubExists();

        $this->info("Entity '{$generator->getValueObjectPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
