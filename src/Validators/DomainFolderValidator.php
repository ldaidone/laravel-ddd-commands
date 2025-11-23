<?php

namespace Ldaidone\LaravelDddCommands\Validators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Validator class for checking domain folder structures.
 *
 * This validator checks if domain folders and required subfolders exist
 * and whether they contain files, helping ensure proper DDD structure.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class DomainFolderValidator
{
    /**
     * The name of the domain being validated.
     */
    protected string $domain;

    /**
     * The base path to the domain directory.
     */
    protected string $basePath;

    /**
     * The list of required folders that should exist in each domain.
     */
    protected array $requiredFolders = [
        'Entities',
        'ValueObjects',
        'Repositories',
        'UseCases',
    ];

    /**
     * Initialize the domain folder validator with a domain name.
     *
     * @param  string  $domain  The name of the domain to validate
     */
    public function __construct(string $domain)
    {
        $this->domain = Str::studly($domain);
        $this->basePath = base_path("app/Domain/{$this->domain}");
    }

    /**
     * Check if the domain directory exists.
     *
     * @return bool True if the domain directory exists, false otherwise
     */
    public function exists(): bool
    {
        return File::isDirectory($this->basePath);
    }

    /**
     * Validate the existence of required folders.
     *
     * This method checks if each required folder exists in the domain directory.
     *
     * @return array An associative array with folder names as keys and boolean values indicating existence
     */
    public function validateFolders(): array
    {
        $results = [];

        foreach ($this->requiredFolders as $folder) {
            $path = "{$this->basePath}/{$folder}";

            $results[$folder] = File::isDirectory($path);
        }

        return $results;
    }

    /**
     * Check if any required folders are empty.
     *
     * This method checks if any of the required folders exist but contain no files.
     *
     * @return array An array containing the names of empty folders
     */
    public function hasEmptyFolders(): array
    {
        $empty = [];

        foreach ($this->requiredFolders as $folder) {
            $path = "{$this->basePath}/{$folder}";

            if (File::isDirectory($path)) {
                $files = File::files($path);
                if (count($files) === 0) {
                    $empty[] = $folder;
                }
            }
        }

        return $empty;
    }

    /**
     * Perform strict validation of the domain structure.
     *
     * This method checks if the domain exists and all required folders exist.
     *
     * @return array An array with validation results
     */
    public function validateStrict(): array
    {
        $results = [
            'domains_exists' => $this->exists(),
            'folders' => $this->validateFolders(),
            'empty_folders' => $this->hasEmptyFolders(),
            'entities' => [],
        ];

        // Deep validation: entities + repos + VOs
        $entitiesPath = "{$this->basePath}/Entities";
        if (! File::isDirectory($entitiesPath)) {
            return $results;
        }

        $entities = File::files($entitiesPath);
        foreach ($entities as $entityFile) {
            $entity = $entityFile->getFilenameWithoutExtension();
            $results['entities'][$entity] = $this->validateEntity($entity);
        }

        return $results;
    }

    /**
     * Validate the required files for a specific entity.
     *
     * This method checks if the repository interface, repository implementation,
     * and ID value object exist for a specific entity.
     *
     * @param  string  $entity  The name of the entity to validate
     * @return array An array with validation results for the entity's components
     */
    protected function validateEntity(string $entity): array
    {
        $repoInterface = "{$this->basePath}/Repositories/{$entity}RepositoryInterface.php";
        $repoImpl = "{$this->basePath}/Repositories/{$entity}Repository.php";
        $voId = "{$this->basePath}/ValueObjects/{$entity}Id.php";

        return [
            'repository_interface' => File::exists($repoInterface),
            'repository_eloquent' => File::exists($repoImpl),
            'id_value_object' => File::exists($voId),
        ];
    }
}
