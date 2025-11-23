<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Generators\DomainGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

/**
 * Console command to create a new DDD domain folder structure.
 *
 * This command generates the basic folder structure for a new domain inside the app/Domain directory.
 * It creates all the necessary subdirectories following DDD conventions.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class CreateDomainCommand extends Command
{
    use ExposesSignature;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:create-domain {name : The name of the domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DDD domain folder structure inside app/Domain';

    /**
     * Execute the console command.
     *
     * This method handles the creation of a new domain structure by:
     * 1. Extracting the domain name from the provided argument
     * 2. Creating the domain directory structure if it doesn't already exist
     *
     * @return int The command exit code
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

    /**
     * Extract the domain name from the full domain name.
     *
     * @param  string  $name  The full domain name
     * @return string The extracted domain name
     */
    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
