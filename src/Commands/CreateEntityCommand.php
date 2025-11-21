<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\EntityGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateEntityCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-entity {name}';

    protected $description = 'Create a new DDD Entity class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new EntityGenerator($name);

        if ($generator->exists()) {
            $this->error("Entity '{$generator->getEntityPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createEntityIfStubExists();

        $this->info("Entity '{$generator->getEntityPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
