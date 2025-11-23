<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class AggregatedGenerator extends BaseGenerator
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
        $this->class = $this->entity.'Aggregate';
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\Aggregates';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/Aggregates/{$this->entity}.php");
        $this->type = 'aggregate';

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
        ];
    }

    public function getAggregatePath(): string
    {
        return $this->path ?? '';
    }

    public function createAgregateIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->rootNamespace,
            $this->domain,
            $this->entity,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
