<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\CommandGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateCommandCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-command {name}';

    protected $description = 'Create a new DDD Command class';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new CommandGenerator($name);

        if ($generator->exists()) {
            $this->error("Command '{$generator->getCommandPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createCommandIfStubExists();

        $this->info("Command '{$generator->getCommandPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
