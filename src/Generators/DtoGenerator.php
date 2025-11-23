<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD DTO (Data Transfer Object) classes.
 *
 * This generator creates DTO classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class DtoGenerator extends BaseGenerator
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
     * Initialize the DTO generator with the provided name.
     *
     * @param string $name The name of the DTO in format "Domain/DTO"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\DataTransferObjects';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/DataTransferObjects/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'dto';

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
     * Get the path to the generated DTO file.
     *
     * @return string The path to the DTO file
     */
    public function getDtoPath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the DTO class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the DTO class file.
     *
     * @return void
     */
    public function createDtoIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
