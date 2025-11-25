<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Generator class for creating DDD domain folder structures.
 *
 * This generator creates the basic folder structure for a domain
 * including all required subdirectories and a README file.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class DomainGenerator extends BaseGenerator
{
    /**
     * The name of the domain being generated.
     */
    protected string $name;

    /**
     * The path to the domain directory.
     */
    protected string $domainPath;

    /**
     * Initialize the domain generator with the provided name.
     *
     * @param  string  $name  The name of the domain
     */
    public function __construct(string $name)
    {
        $this->name = Str::studly($name);
        // Use the helper from BaseGenerator (which reads config)
        // We need to ensure we use the base path relative to project root
        $this->domainPath = $this->basePath($this->getDomainPath()."/{$this->name}");

        // Stub path matching the exact type name
        $this->stubPath = __DIR__ . "/../../stubs/ddd/domain-readme.stub";

    }

    /**
     * Check if the domain directory already exists.
     *
     * @return bool True if the domain exists, false otherwise
     */
    public function exists(): bool
    {
        return File::exists($this->domainPath);
    }

    /**
     * Create the domain directory structure.
     *
     * This method creates the main domain directory and all required
     * subdirectories if they don't already exist, adding .gitkeep files.
     */
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

    /**
     * Create a README.md file for the domain if the stub exists.
     *
     * This method processes the domain README stub file by replacing placeholders
     * with actual values and creates the README file for the domain.
     */
    public function createReadmeIfStubExists(): void
    {
        //$stubPath = __DIR__ . '/../../stubs/domain-readme.stub';

        if (!File::exists($this->stubPath)) {
            return;
        }

        $stub = File::get($this->stubPath);

        $contents = str_replace(
            ['{{ domain }}'],
            [$this->name],
            $stub
        );

        File::put("{$this->domainPath}/README.md", $contents);
    }

    /**
     * Get the tags to be replaced in the stub file.
     *
     * @return array The array of placeholder tags to replace
     */
    protected function getTags(): array
    {
        return [
            '{{ domain }}'
        ];
    }

    /**
     * Get the list of required folders for a domain.
     *
     * @return array The array of required folder names
     */
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
