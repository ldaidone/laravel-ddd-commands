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
        // Use the helper from BaseGenerator (which reads config)
        // We need to ensure we use the base path relative to project root
        $this->domainPath = base_path($this->getDomainPath()."/{$this->name}");
    }

    public function exists(): bool
    {
        return File::exists($this->domainPath);
    }

    public function createDirectories(): void
    {
        if (! File::exists($this->domainPath)) {
            File::makeDirectory($this->domainPath, 0777, true);
        }
        foreach ($this->folders() as $folder) {
            $path = "{$this->domainPath}/{$folder}";
            if (! File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }
            File::put("{$path}/.gitkeep", '');
        }
    }

    public function createReadmeIfStubExists(): void
    {
        $stubPath = __DIR__.'/../../stubs/ddd/domain-readme.stub';

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

    protected function getDomainPath(): string
    {
        return config('ddd-commands.domain_path', 'app/Domain');
    }
}
