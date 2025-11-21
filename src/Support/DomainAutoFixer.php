<?php

namespace Ldaidone\LaravelDddCommands\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DomainAutoFixer
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
        $domainPath = config('ddd-commands.domain_path', 'app/Domain');
        $this->basePath = base_path("{$domainPath}/{$this->domain}");
    }

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
