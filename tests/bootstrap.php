<?php

// Minimal Laravel app setup for testing
if (! function_exists('app_path')) {
    function app_path($path = '')
    {
        // For testing purposes, return a mock path
        return __DIR__.'/temp_app'.($path ? '/'.$path : '');
    }
}

if (! function_exists('app')) {
    function app($abstract = null)
    {
        // Mock Laravel's app() function
        if ($abstract === null) {
            // Return a minimal mock that has a getNamespace method
            $mockApp = new class
            {
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
