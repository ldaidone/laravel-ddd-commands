<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class ValueObjectGenerator extends BaseGenerator
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
        $this->namespace = $this->rootNamespace . '\\' . $this->domain . '\\ValueObjects';

        $this->path = app_path("Domains/{$this->domain}/ValueObjects/{$this->entity}.php");
        $this->type = "value-object";
    }

    protected function getTags(): array
    {
        return [
            '{{ namespace }}',
            '{{ class }}'
        ];
    }

    public function getValueObjectPath(): string
    {
        return $this->path ?? '';
    }

    public function createValueObjectIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class
        ];
        $this->createIfStubExists($this->getTags(),$replacements);
    }
}