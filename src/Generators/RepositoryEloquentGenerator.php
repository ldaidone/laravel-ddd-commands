<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class RepositoryEloquentGenerator extends BaseGenerator
{
    protected string $namespace;

    protected string $rootNamespace;

    protected string $domain;

    protected string $entity;

    protected string $class;

    protected string $interface;

    public function __construct(string $name, string $interface)
    {
        $this->rootNamespace = rtrim(app()->getNamespace(), '\\');

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));

        $this->class = $this->entity.'EloquentRepository';
        $this->interface = Str::studly($interface);

        // Use configured infrastructure namespace
        $this->namespace = $this->getInfrastructureNamespace()."\\Database\\{$this->domain}\\Repositories";

        // Use configured infrastructure path
        $this->path = base_path($this->getInfrastructurePath()."/Database/{$this->domain}/Repositories/{$this->class}.php");

        $this->type = 'repository-eloquent';

        parent::__construct($this->path, $this->type);
    }

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

    public function getRepositoryEloquentPath(): string
    {
        return $this->path ?? '';
    }

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
