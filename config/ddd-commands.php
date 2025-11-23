<?php

/**
 * Configuration file for the Laravel DDD Commands package.
 *
 * This file contains the default configuration options for the package,
 * including paths and namespaces for domain and infrastructure code.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */

return [
    /*
    |--------------------------------------------------------------------------
    | Domain Path
    |--------------------------------------------------------------------------
    |
    | The path where your domains will be located.
    | Default: app/Domain
    |
    */
    'domain_path' => 'app/Domain',

    /*
    |--------------------------------------------------------------------------
    | Domain Namespace
    |--------------------------------------------------------------------------
    |
    | The root namespace for your domains.
    | Default: App\Domain
    |
    */
    'domain_namespace' => 'App\Domain',

    /*
    |--------------------------------------------------------------------------
    | Infrastructure Path
    |--------------------------------------------------------------------------
    |
    | The path where your infrastructure code (like repositories) will be located.
    | Default: app/Infrastructure
    |
    */
    'infrastructure_path' => 'app/Infrastructure',

    /*
    |--------------------------------------------------------------------------
    | Infrastructure Namespace
    |--------------------------------------------------------------------------
    |
    | The root namespace for your infrastructure code.
    | Default: App\Infrastructure
    |
    */
    'infrastructure_namespace' => 'App\Infrastructure',
];
