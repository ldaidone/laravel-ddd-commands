<?php

namespace Tests;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Ldaidone\LaravelDddCommands\LaravelDddCommandsServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class GeneratorTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LaravelDddCommandsServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Prepare temporary directory for generated files
        $this->prepareTempDir();
    }

    protected function tearDown(): void
    {
        $this->cleanupTempDir();
        parent::tearDown();
    }

    protected function prepareTempDir()
    {
        $tempPath = base_path('tests/temp');
        Config::set('ddd-commands.domain_path', 'tests/temp/Domain');
        Config::set('ddd-commands.infrastructure_path', 'tests/temp/Infrastructure');
        Config::set('ddd-commands.domain_namespace', 'Tests\\Temp\\Domain');
        Config::set('ddd-commands.infrastructure_namespace', 'Tests\\Temp\\Infrastructure');

        if (! File::isDirectory($tempPath)) {
            File::makeDirectory($tempPath, 0777, true);
        }
    }

    protected function cleanupTempDir()
    {
        if (defined('DDD_TESTING_BASE_PATH')) {
            $tempPath = DDD_TESTING_BASE_PATH;
        } else {
            $tempPath = base_path('tests/temp');
        }

        if (File::isDirectory($tempPath)) {
            File::deleteDirectory($tempPath);
        }
    }
}
