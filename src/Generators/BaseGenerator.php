<?php

namespace Ldaidone\LaravelDddCommands\Generators;

use Illuminate\Support\Facades\File;

/**
 * Base generator class for creating DDD components.
 *
 * This class provides common functionality for generating DDD components
 * such as entities, use cases, commands, queries, etc. It handles file
 * creation, stub management, and directory creation.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class BaseGenerator
{
    /**
     * The file path where the generated class will be saved.
     */
    protected string $path = '';

    /**
     * The type of DDD component being generated (e.g., entity, usecase, command).
     */
    protected string $type = '';

    /**
     * The path to the stub template file for this component type.
     */
    protected string $stubPath = '';

    /**
     * Initialize the base generator with path and type.
     *
     * This constructor sets up the paths for the target file and stub template,
     * checking if a published stub exists to override the default stub.
     *
     * @param  string  $path  The file path where the generated class will be saved
     * @param  string  $type  The type of DDD component being generated
     */
    public function __construct(string $path, string $type)
    {
        // Accept path as raw and untouched
        $this->path = $path;

        // Type comes exactly as provided
        $this->type = $type;

        // Stub path matching the exact type name
         $this->stubPath = __DIR__ . "/../../stubs/ddd/{$this->type}.stub";

        // allow override via published stub
        $publishedStub = resource_path("stubs/ddd-commands/{$this->type}.stub");
        if (File::exists($publishedStub)) {
            $this->stubPath = $publishedStub;
        }
    }

    protected function basePath(string $path): string
    {
        return defined('DDD_TESTING_BASE_PATH')
            ? DDD_TESTING_BASE_PATH . '/' . $path     // used in tests
            : base_path($path);               // used in real apps
    }

    protected function rootNamespace(): string
    {
        return defined('DDD_TESTING_NAMESPACE')
            ? DDD_TESTING_NAMESPACE      // used in tests
            : app()->getNamespace();     // used in real apps
    }

    /**
     * Get the path to the stub template file.
     *
     * @return string The stub file path
     */
    public function getStubPath(): string
    {
        return $this->stubPath;
    }

    /**
     * Check if the target file already exists.
     *
     * @return bool True if the file exists, false otherwise
     */
    public function exists(): bool
    {
        return File::exists($this->path);
    }

    /**
     * Check if the stub template file exists.
     *
     * @return bool True if the stub exists, false otherwise
     */
    public function doesStubExist(): bool
    {
        return File::exists($this->stubPath);
    }

    /**
     * Create a file from the stub if the stub exists.
     *
     * This method handles the creation of a new file by replacing
     * placeholders in the stub with actual values.
     *
     * @param  array  $tags  Array of placeholder tags to replace
     * @param  array  $replacements  Array of replacement values for the tags
     * @return string The path to the created file, or empty string if stub doesn't exist
     */
    protected function createIfStubExists(array $tags, array $replacements): string
    {
        if (! $this->doesStubExist()) {
            return '';
        }

        $dir = dirname($this->path);
        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0777, true);
        }

        $contents = str_replace(
            $tags,
            $replacements,
            File::get($this->stubPath),
        );

        File::put($this->path, $contents);

        return $this->path;
    }

    /**
     * Get the configured domain path from the package configuration.
     *
     * @return string The domain path, defaulting to 'app/Domain'
     */
    protected function getDomainPath(): string
    {
        return 'app/Domains';
    }

    /**
     * Get the configured domain namespace from the package configuration.
     *
     * @return string The domain namespace, defaulting to 'App\Domain'
     */
    protected function getDomainNamespace(): string
    {
        $root = rtrim($this->rootNamespace(), '\\');
        return $root . '\\Domains';
    }

    /**
     * Get the configured Application path from the package configuration.
     *
     * @return string The Application path, defaulting to 'app/Application'
     */
    protected function getApplicationPath(): string
    {
        return $this->basePath('app/Application');
    }

    /**
     * Get the configured Application namespace from the package configuration.
     *
     * @return string The Application namespace, defaulting to 'App\Application'
     */
    protected function getApplicationNamespace(): string
    {
        return 'App\\Application';
    }

    /**
     * Get the configured infrastructure path from the package configuration.
     *
     * @return string The infrastructure path, defaulting to 'app/Infrastructure'
     */
    protected function getInfrastructurePath(): string
    {
        return 'app/Infrastructure';
    }

    /**
     * Get the configured infrastructure namespace from the package configuration.
     *
     * @return string The infrastructure namespace, defaulting to 'App\Infrastructure'
     */
    protected function getInfrastructureNamespace(): string
    {
        $root = rtrim($this->rootNamespace(), '\\');
        return $root . '\\Infrastructure\\Domains';
    }
}
