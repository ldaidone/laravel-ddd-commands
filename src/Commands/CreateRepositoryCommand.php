<?php

namespace Ldaidone\LaravelDddCommands\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Ldaidone\LaravelDddCommands\Commands\Concerns\ExposesSignature;
use Ldaidone\LaravelDddCommands\Exceptions\RepositoryEloquentAlreadyExistsException;
use Ldaidone\LaravelDddCommands\Exceptions\RepositoryInterfaceAlreadyExistsException;
use Ldaidone\LaravelDddCommands\Generators\RepositoryEloquentGenerator;
use Ldaidone\LaravelDddCommands\Generators\RepositoryInterfaceGenerator;

class CreateRepositoryCommand extends Command
{
    use ExposesSignature;

    protected $signature = 'ddd:create-repository {name}';
    protected $description = 'Create a new DDD repository (interface + eloquent)';

    public function handle()
    {
        $name = $this->argument('name');

        try {
            $interfacePath = $this->generateInterface($name);
            $this->info("Repository Interface created: {$interfacePath}");

            $eloquentPath  = $this->generateEloquent($name);
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

    private function generateInterface(string $name): string
    {
        $generator = new RepositoryInterfaceGenerator($name);

        if ($generator->exists($generator->getRepositoryInterfacePath())) {
            throw new RepositoryInterfaceAlreadyExistsException(
                "Interface already exists: {$generator->getRepositoryInterfacePath()}"
            );
        }

        $generator->createRepositoryInterfaceIfStubExists();

        return $generator->getRepositoryInterfacePath();
    }

    private function generateEloquent(string $name): string
    {
        // FIX: pass interface name explicitly
        $interfaceName = Str::studly($name) . 'RepositoryInterface';

        $generator = new RepositoryEloquentGenerator($name, $interfaceName);

        if ($generator->exists($generator->getRepositoryEloquentPath())) {
            throw new RepositoryEloquentAlreadyExistsException(
                "Eloquent Repository already exists: {$generator->getRepositoryEloquentPath()}"
            );
        }

        $generator->createRepositoryEloquentIfStubExists();

        return $generator->getRepositoryEloquentPath();
    }
}
