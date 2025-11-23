<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD Value Object classes.
 *
 * This generator creates value object classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class ValueObjectGenerator extends BaseGenerator
{
    /**
     * The namespace for the generated class.
     *
     * @var string
     */
    protected string $namespace;

    /**
     * The root namespace for the domain.
     *
     * @var string
     */
    protected string $rootNamespace;

    /**
     * The domain name.
     *
     * @var string
     */
    protected string $domain;

    /**
     * The entity name.
     *
     * @var string
     */
    protected string $entity;

    /**
     * The class name.
     *
     * @var string
     */
    protected string $class;

    /**
     * Initialize the value object generator with the provided name.
     *
     * @param string $name The name of the value object in format "Domain/ValueObject"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\ValueObjects';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/ValueObjects/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'value-object';

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
     * Get the path to the generated value object file.
     *
     * @return string The path to the value object file
     */
    public function getValueObjectPath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the value object class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the value object class file.
     *
     * @return void
     */
    public function createValueObjectIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
