<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\DomainGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateDomainCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-domain {name : The name of the domain}';

    protected $description = 'Create a new DDD domain folder structure inside app/Domain';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $generator = new DomainGenerator($name);

        if ($generator->exists()) {
            $this->error("Domain '{$name}' already exists.");

            return self::FAILURE;
        }

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator->createDirectories();
        $generator->createReadmeIfStubExists();

        $this->info("Domain '{$name}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
