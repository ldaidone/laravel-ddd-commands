<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\QueryGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateQueryCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-query {name}';

    protected $description = 'Create a new DDD Query class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new QueryGenerator($name);

        if ($generator->exists()) {
            $this->error("Query '{$generator->getQueryPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createQueryIfStubExists();

        $this->info("Query '{$generator->getQueryPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}