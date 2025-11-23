<?php

namespace Ldaidone\LaravelDddCommands\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Domain auto-fixer utility class.
 *
 * This class ensures that the required domain folder structure exists
 * when generating DDD components. It creates the necessary directories
 * if they don't already exist.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class DomainAutoFixer
{
    /**
     * The name of the domain being processed.
     *
     * @var string
     */
    protected string $domain;

    /**
     * The base path for the domain directory.
     *
     * @var string
     */
    protected string $basePath;

    /**
     * The list of required subfolders that should exist in each domain.
     *
     * @var array
     */
    protected array $requiredFolders = [
        'Entities',
        'ValueObjects',
        'Repositories',
        'UseCases',
    ];

    /**
     * Initialize the domain auto-fixer with a domain name.
     *
     * @param string $domain The name of the domain to process
     */
    public function __construct(string $domain)
    {
        $this->domain = Str::studly($domain);
        $domainPath = config('ddd-commands.domain_path', 'app/Domain');
        $this->basePath = base_path("{$domainPath}/{$this->domain}");
    }

    /**
     * Ensure that the domain folder structure exists.
     *
     * This method creates the main domain directory and all required
     * subdirectories if they don't already exist.
     *
     * @return void
     */
    public function ensureDomainStructure(): void
    {
        // Create domain folder if missing
        if (! File::isDirectory($this->basePath)) {
            File::makeDirectory($this->basePath, 0755, true);
        }

        // Create subfolders if missing
        foreach ($this->requiredFolders as $folder) {
            $path = "{$this->basePath}/{$folder}";
            if (! File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true);
            }
        }
    }
}
