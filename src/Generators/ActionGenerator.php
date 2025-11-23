<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD Action classes.
 *
 * This generator creates action classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class ActionGenerator extends BaseGenerator
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
     * Initialize the action generator with the provided name.
     *
     * @param  string  $name  The name of the action in format "Domain/Action"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\Actions';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/Actions/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'action';

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
     * Get the path to the generated action file.
     *
     * @return string The path to the action file
     */
    public function getActionPath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the action class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the action class file.
     */
    public function createActionIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
