<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class RepositoryInterfaceGenerator extends BaseGenerator
{
    protected string $namespace;
    protected string $rootNamespace;
    protected string $domain;
    protected string $entity;
    protected string $class;

    public function __construct(string $name)
    {
        $this->rootNamespace = rtrim(app()->getNamespace(), '\\');

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->class = $this->entity . 'RepositoryInterface';

        $this->namespace = $this->rootNamespace . '\\' . $this->domain . '\\Repositories\\';
        $this->path = app_path("Domains/{$this->domain}/Repositories/{$this->class}.php");
        $this->type = "repository-interface";

        parent::__construct($this->path, $this->type);
    }


    protected function getTags(): array
    {
        return [
            '{{ namespace }}',
            '{{ class }}'
        ];
    }

    public function getRepositoryInterfacePath(): string
    {
        return $this->path ?? '';
    }

    public function createRepositoryInterfaceIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class
        ];

        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
