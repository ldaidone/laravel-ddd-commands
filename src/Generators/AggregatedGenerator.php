<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD Aggregate classes.
 *
 * This generator creates aggregate root classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class AggregatedGenerator extends BaseGenerator
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
     * Initialize the aggregate generator with the provided name.
     *
     * @param  string  $name  The name of the aggregate in format "Domain/Aggregate"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->rootNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->getDomainNamespace().'\\'.$this->domain.'\\Aggregates';

        $this->path = $this->basePath($this->getDomainPath()."/{$this->domain}/Aggregates/{$this->entity}.php");
        $this->class = $this->entity.'Aggregate';
        $this->type = 'aggregate';

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
        ];
    }

    /**
     * Get the path to the generated aggregate file.
     *
     * @return string The path to the aggregate file
     */
    public function getAggregatePath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the aggregate class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the aggregate class file.
     */
    public function createAgregateIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->rootNamespace,
            $this->domain,
            $this->entity,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
