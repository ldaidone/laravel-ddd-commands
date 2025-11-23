<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

/**
 * Console command to create a new DDD event class.
 *
 * This command generates a new event class using the DDD structure and conventions.
 * It creates the necessary folder structure if it doesn't exist and uses stub templates
 * to generate the boilerplate code for the event.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class CreateEventCommand extends Command
{
    use ExposesSignature;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:create-event {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DDD event class';

    /**
     * Execute the console command.
     *
     * This method handles the creation of a new event class by:
     * 1. Extracting the domain from the provided name
     * 2. Ensuring the domain structure exists
     * 3. Creating the event if it doesn't already exist
     *
     * @return int The command exit code
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new \Ldaidone\LaravelDddCommands\Generators\EventGenerator($name);

        if ($generator->exists()) {
            $this->error("Event '{$generator->getEventPath()}' already exists.");

            return Command::FAILURE;
        }

        $generator->createEventIfStubExists();

        $this->info("Event '{$generator->getEventPath()}' created successfully.");

        return Command::SUCCESS;
    }

    /**
     * Extract the domain name from the full event name.
     *
     * @param string $name The full name in format "Domain/Event"
     * @return string The extracted domain name
     */
    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
