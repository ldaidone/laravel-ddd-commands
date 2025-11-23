<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Exceptions\RepositoryEloquentAlreadyExistsException;
use Ldaidone\LaravelDddCommands\Exceptions\RepositoryInterfaceAlreadyExistsException;
use Ldaidone\LaravelDddCommands\Generators\RepositoryEloquentGenerator;
use Ldaidone\LaravelDddCommands\Generators\RepositoryInterfaceGenerator;
use Ldaidone\LaravelDddCommands\Support\DomainAutoFixer;

/**
 * Console command to create a new DDD repository (interface + eloquent implementation).
 *
 * This command generates both a repository interface and its Eloquent implementation
 * using the DDD structure and conventions. It creates the necessary folder structure
 * if it doesn't exist and uses stub templates to generate the boilerplate code.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class CreateRepositoryCommand extends Command
{
    use ExposesSignature;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddd:create-repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DDD repository (interface + eloquent)';

    /**
     * Execute the console command.
     *
     * This method handles the creation of repository files by:
     * 1. Generating the repository interface
     * 2. Generating the Eloquent repository implementation
     * 3. Handling any exceptions that may occur during generation
     *
     * @return int The command exit code
     */
    public function handle()
    {
        $name = $this->argument('name');

        try {
            $interfacePath = $this->generateInterface($name);
            $this->info("Repository Interface created: {$interfacePath}");

            $eloquentPath = $this->generateEloquent($name);
            $this->info("Repository Eloquent created: {$eloquentPath}");

            return Command::SUCCESS;

        } catch (RepositoryInterfaceAlreadyExistsException $e) {

            $this->error($e->getMessage());

            return Command::FAILURE;

        } catch (RepositoryEloquentAlreadyExistsException $e) {

            $this->error($e->getMessage());

            return Command::FAILURE;
        }
    }

    /**
     * Generate the repository interface file.
     *
     * This method creates the repository interface using the appropriate generator.
     * If the interface already exists, it throws an exception.
     *
     * @param  string  $name  The name of the repository
     * @return string The path to the created interface file
     *
     * @throws RepositoryInterfaceAlreadyExistsException If the interface already exists
     */
    private function generateInterface(string $name): string
    {
        $generator = new RepositoryInterfaceGenerator($name);

        if ($generator->exists()) {
            throw new RepositoryInterfaceAlreadyExistsException(
                "Interface already exists: {$generator->getRepositoryInterfacePath()}"
            );
        }

        $generator->createRepositoryInterfaceIfStubExists();

        return $generator->getRepositoryInterfacePath();
    }

    /**
     * Generate the Eloquent repository implementation file.
     *
     * This method creates the Eloquent repository implementation using the appropriate generator.
     * If the implementation already exists, it throws an exception.
     *
     * @param  string  $name  The name of the repository
     * @return string The path to the created Eloquent repository file
     *
     * @throws RepositoryEloquentAlreadyExistsException If the Eloquent repository already exists
     */
    private function generateEloquent(string $name): string
    {
        // FIX: pass interface name explicitly
        $interfaceName = Str::studly($name).'RepositoryInterface';

        $domain = $this->extractDomain($name);

        $autoFixer = new DomainAutoFixer($domain);
        $autoFixer->ensureDomainStructure();

        $generator = new RepositoryEloquentGenerator($name, $interfaceName);

        if ($generator->exists()) {
            throw new RepositoryEloquentAlreadyExistsException(
                "Eloquent Repository already exists: {$generator->getRepositoryEloquentPath()}"
            );
        }

        $generator->createRepositoryEloquentIfStubExists();

        return $generator->getRepositoryEloquentPath();
    }

    /**
     * Extract the domain name from the full repository name.
     *
     * @param  string  $name  The full name in format "Domain/Repository"
     * @return string The extracted domain name
     */
    protected function extractDomain(string $name): string
    {
        return explode('/', $name)[0];
    }
}
