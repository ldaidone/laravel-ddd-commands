<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

/**
 * Generator class for creating DDD UseCase classes.
 *
 * This generator creates use case classes following DDD conventions and structure.
 * It extends the BaseGenerator to handle file creation and stub processing.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class UseCaseGenerator extends BaseGenerator
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
     * Initialize the use case generator with the provided name.
     *
     * @param string $name The name of the use case in format "Domain/UseCase"
     */
    public function __construct(string $name)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\UseCases';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/UseCases/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'usecase';

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
     * Get the path to the generated use case file.
     *
     * @return string The path to the use case file
     */
    public function getUseCasePath(): string
    {
        return $this->path ?? '';
    }

    /**
     * Create the use case class if the stub file exists.
     *
     * This method processes the stub file by replacing placeholders
     * with actual values and creates the use case class file.
     *
     * @return void
     */
    public function createUseCaseIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
