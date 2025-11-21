<?php

namespace Ldaidone\LaravelDddCommands\Validators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DomainFolderValidator
{
    protected string $domain;

    protected string $basePath;

    protected array $requiredFolders = [
        'Entities',
        'ValueObjects',
        'Repositories',
        'UseCases',
    ];

    public function __construct(string $domain)
    {
        $this->domain = Str::studly($domain);
        $this->basePath = base_path("app/Domain/{$this->domain}");
    }

    public function exists(): bool
    {
        return File::isDirectory($this->basePath);
    }

    public function validateFolders(): array
    {
        $results = [];

        foreach ($this->requiredFolders as $folder) {
            $path = "{$this->basePath}/{$folder}";

            $results[$folder] = File::isDirectory($path);
        }

        return $results;
    }

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
