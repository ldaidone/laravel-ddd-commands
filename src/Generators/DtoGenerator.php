<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Str;

class DtoGenerator extends BaseGenerator
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
        $this->namespace = $this->rootNamespace.'\\'.$this->domain.'\\DataTransferObjects';

        $this->path = base_path($this->getDomainPath()."/{$this->domain}/DataTransferObjects/{$this->entity}.php");
        $this->class = $this->entity;
        $this->type = 'dto';

        parent::__construct($this->path, $this->type);
    }

    protected function getTags(): array
    {
        return [
            '{{ namespace }}',
            '{{ class }}',
        ];
    }

    public function getDtoPath(): string
    {
        return $this->path ?? '';
    }

    public function createDtoIfStubExists(): void
    {
        $replacements = [
            $this->namespace,
            $this->class,
        ];
        $this->createIfStubExists($this->getTags(), $replacements);
    }
}
