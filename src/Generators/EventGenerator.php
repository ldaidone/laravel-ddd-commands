<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class EventGenerator extends BaseGenerator
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
        $this->class = $this->entity;
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\Events';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/Events/{$this->entity}.php");
        $this->type = 'event';

        parent::__construct($this->path, $this->type);
    }

    protected function getTags(): array
    {
        return [
            '{{ namespace }}',
            '{{ class }}',
        ];
    }

    public function getEventPath(): string
    {
        return $this->path ?? '';
    }

    public function createEventIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
