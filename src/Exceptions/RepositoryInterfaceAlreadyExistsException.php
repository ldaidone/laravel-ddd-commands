<?php

namespace Ldaidone\LaravelDddCommands\Exceptions;

/**
 * Exception thrown when a repository interface already exists.
 *
 * This exception is used when attempting to create a repository interface that already exists.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
class RepositoryInterfaceAlreadyExistsException extends \Exception {}
