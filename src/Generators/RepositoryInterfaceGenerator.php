<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD Repository interface classes.
 *
 * This generator creates repository interface classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class RepositoryInterfaceGenerator extends BaseGenerator
{
    /**
     * The namespace for the generated class.
     */
    protected string $namespace;

    /**
     * The root namespace for the domain.
     */
    protected string $rootNamespace;

    /**
     * The domain name.
     */
    protected string $domain;

    /**
     * The entity name.
     */
    protected string $entity;

    /**
     * The class name.
     */
    protected string $class;

    /**
     * Initialize the repository interface generator with the provided name.
     *
     * @param  string  $name  The name of the repository interface in format "Domain/Repository"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->class = $this->entity.'RepositoryInterface';

        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\Repositories';
        $this->path = base_path($this->getDomainPath()."/{$this->domain}/Repositories/{$this->class}.php");
        $this->type = 'repository-interface';

        parent::__construct($this->path, $this->type);
    }

    /**
     * Get the tags to be replaced in the stub file.
     *
     * @return array The array of placeholder tags to replace
     */
    protected function getTags(): array
    {
        return [
            '{{ namespace }}',
            '{{ class }}',
        ];
    }

    /**
     * Get the path to the generated repository interface file.
     *
     * @return string The path to the repository interface file
     */
    public function getRepositoryInterfacePath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the repository interface class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the repository interface class file.
     */
    public function createRepositoryInterfaceIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];

        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
