<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\ActionGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

class CreateActionCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-action {name} {--debug}';

    protected $description = 'Create a new DDD Action';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new ActionGenerator($name);

        if ($generator->exists()) {
            $this->error("Action '{$generator->getActionPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createActionIfStubExists();

        $this->info("Action '{$generator->getActionPath()}' created successfully.");

        return Command::SUCCESS;
    }

    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
