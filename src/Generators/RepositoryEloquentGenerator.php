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

        $this->class     = $this->entity . 'EloquentRepository';
        $this->interface = Str::studly($interface);

        // FIXED — proper namespace
        $this->namespace = "{$this->rootNamespace}\\Domain\\{$this->domain}\\Repositories";

        // FIXED — path should be Infrastructure layer
        $this->path = app_path("Infrastructure/Database/{$this->domain}/Repositories/{$this->class}.php");

        $this->type = "repository-eloquent";
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
