<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD Query classes.
 *
 * This generator creates query classes following CQRS and DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class QueryGenerator extends BaseGenerator
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
     * Initialize the query generator with the provided name.
     *
     * @param  string  $name  The name of the query in format "Domain/Query"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->rootNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->getDomainNamespace().'\\'.$this->domain.'\\Queries';

        $this->path = $this->basePath($this->getDomainPath()."/{$this->domain}/Queries/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'query';

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
     * Get the path to the generated query file.
     *
     * @return string The path to the query file
     */
    public function getQueryPath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the query class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the query class file.
     */
    public function createQueryIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
