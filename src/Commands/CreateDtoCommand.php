<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\DtoGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

/**
 * Console command to create a new DDD Data Transfer Object.
 *
 * This command generates a new DTO class using the DDD structure and conventions.
 * It creates the necessary folder structure if it doesn't exist and uses stub templates
 * to generate the boilerplate code for the DTO.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class CreateDtoCommand extends Command
{
    use ExposesSignature;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:create-dto {name} {--debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DDD Data Transfer Object';

    /**
     * Execute the console command.
     *
     * This method handles the creation of a new DTO class by:
     * 1. Extracting the domain from the provided name
     * 2. Ensuring the domain structure exists
     * 3. Creating the DTO if it doesn't already exist
     *
     * @return int The command exit code
     */
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

    /**
     * Extract the domain name from the full DTO name.
     *
     * @param string $name The full name in format "Domain/DTO"
     * @return string The extracted domain name
     */
    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
