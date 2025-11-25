<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD Repository Eloquent implementation classes.
 *
 * This generator creates Eloquent repository implementation classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class RepositoryEloquentGenerator extends BaseGenerator
{
    /**
     * The namespace for the generated class.
     */
    protected string $namespace;

    /**
     * The root namespace for the application.
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
     * The interface name.
     */
    protected string $interface;

    /**
     * Initialize the repository Eloquent generator with the provided name and interface.
     *
     * @param  string  $name  The name of the repository in format "Domain/Repository"
     * @param  string  $interface  The name of the interface the repository implements
     */
    public function __construct(string $name, string $interface)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));

        $this->class = $this->entity.'EloquentRepository';

        $ifaceArray = explode('/', Str::studly($interface));
        $this->interface = end($ifaceArray);

        // Use configured infrastructure namespace
        $this->namespace = $this->getInfrastructureNamespace()."\\Database\\{$this->domain}\\Repositories";

        // Use configured infrastructure path
        $this->path = $this->basePath($this->getInfrastructurePath()."/Database/{$this->domain}/Repositories/{$this->class}.php");

        $this->type = 'repository-eloquent';

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
            '{{ rootNamespace }}',
            '{{ domain }}',
            '{{ entity }}',
            '{{ class }}',
            '{{ interface }}',
        ];
    }

    /**
     * Get the path to the generated repository Eloquent file.
     *
     * @return string The path to the repository Eloquent file
     */
    public function getRepositoryEloquentPath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the repository Eloquent class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the repository Eloquent class file.
     */
    public function createRepositoryEloquentIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->rootNamespace,
            $this->domain,
            $this->entity,
            $this->class,
            $this->interface,
        ];

        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
