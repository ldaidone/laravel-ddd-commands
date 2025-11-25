<?php

// Define where generators should write inside tests
define('DDD_TESTING_BASE_PATH', basePath('tests/temp'));

// Define what namespace generated classes should use during tests
define('DDD_TESTING_NAMESPACE', 'Tests\\Temp\\');

// Clean test directory before each run
if (is_dir(DDD_TESTING_BASE_PATH)) {
    exec('rm -rf ' . escapeshellarg(DDD_TESTING_BASE_PATH));
}

mkdir(DDD_TESTING_BASE_PATH, 0777, true);

function basePath(string $path)
{
    return realpath(__DIR__ . '/../') . '/' . $path;
}

// Minimal Laravel app setup for testing
if (!function_exists('app_path')) {
    function app_path($path = '')
    {
        // For testing purposes, return a mock path
        return __DIR__ . '/temp_app' . ($path ? '/' . $path : '');
    }
}

if (!function_exists('app')) {
    function app($abstract = null)
    {
        // Mock Laravel's app() function
        if ($abstract === null) {
            // Return a minimal mock that has a getNamespace method
            $mockApp = new class {
                public function getNamespace()
                {
                    return 'App\\';
                }
            };

            return $mockApp;
        }

        return null;
    }
}
