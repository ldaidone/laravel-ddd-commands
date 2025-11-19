<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DomainGenerator
{
    protected string $name;
    protected string $domainPath;

    public function __construct(string $name)
    {
        $this->name = Str::studly($name);
        $this->domainPath = app_path("Domain/{$this->name}");
    }

    public function exists(): bool
    {
        return File::exists($this->domainPath);
    }

    public function createDirectories(): void
    {
        foreach ($this->folders() as $folder) {
            $path = "{$this->domainPath}/{$folder}";
            File::makeDirectory($path, 0755, true);
            File::put("{$path}/.gitkeep", '');
        }
    }

    public function createReadmeIfStubExists(): void
    {
        $stubPath = __DIR__ . '/../../stubs/domain-readme.stub';

        if (! File::exists($stubPath)) {
            return;
        }

        $stub = File::get($stubPath);

        $contents = str_replace(
            ['{{ domain }}'],
            [$this->name],
            $stub
        );

        File::put("{$this->domainPath}/README.md", $contents);
    }

    protected function folders(): array
    {
        return [
            'Entities',
            'ValueObjects',
            'UseCases',
            'Repositories',
            'Events',
        ];
    }
}
