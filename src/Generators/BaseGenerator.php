<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Facades\File;

class BaseGenerator
{
    protected string $path = '';

    protected string $type = '';

    protected string $stubPath = '';

    public function __construct(string $path, string $type)
    {

        // Accept path as raw and untouched
        $this->path = ucfirst($path);

        // Type comes exactly as provided
        $this->type = $type;

        // Stub path matching the exact type name
        $this->stubPath = __DIR__."/../../stubs/ddd/{$this->type}.stub";

        // Check for published stub override
        $publishedStub = resource_path("stubs/ddd-commands/{$this->type}.stub");
        if (File::exists($publishedStub)) {
            $this->stubPath = $publishedStub;
        }
    }

    public function getStubPath(): string
    {
        return $this->stubPath;
    }

    public function exists(): bool
    {
        return File::exists($this->path);
    }

    public function doesStubExist(): bool
    {
        return File::exists($this->stubPath);
    }

    protected function createIfStubExists(array $tags, array $replacements): string
    {
        if (! $this->doesStubExist()) {
            return '';
        }

        $dir = dirname($this->path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0777, true);
        }

        $stub = File::get($this->stubPath);

        $contents = str_replace($tags, $replacements, $stub);

        File::put($this->path, $contents);

        return $this->path;
    }

    protected function getDomainPath(): string
    {
        return config('ddd-commands.domain_path', 'app/Domain');
    }

    protected function getDomainNamespace(): string
    {
        return config('ddd-commands.domain_namespace', 'App\Domain');
    }

    protected function getInfrastructurePath(): string
    {
        return config('ddd-commands.infrastructure_path', 'app/Infrastructure');
    }

    protected function getInfrastructureNamespace(): string
    {
        return config('ddd-commands.infrastructure_namespace', 'App\Infrastructure');
    }
}
