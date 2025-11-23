<?php

namespace Ldaidone\LaravelDddCommands\Exceptions;

/**
 * Exception thrown when a repository Eloquent implementation already exists.
 *
 * This exception is used when attempting to create a repository Eloquent implementation that already exists.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class RepositoryEloquentAlreadyExistsException extends \Exception {}
