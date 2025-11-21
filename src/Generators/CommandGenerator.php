<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class CommandGenerator extends BaseGenerator
{
    protected string $namespace;

    protected string $rootNamespace;

    protected string $domain;

    protected string $entity;

    protected string $class;

    public function __construct(string $name)
    {
        $this->rootNamespace = $this->getDomainNamespace();

        $parts = explode('/', $name);

        $this->domain = Str::studly($parts[0]);
        $this->entity = Str::studly(end($parts));
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\Commands';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/Commands/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'command';

        parent::__construct($this->path, $this->type);
    }

    protected function getTags(): array
    {
        return [
            '{{ namespace }}',
            '{{ class }}',
        ];
    }

    public function getCommandPath(): string
    {
        return $this->path ?? '';
    }

    public function createCommandIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}