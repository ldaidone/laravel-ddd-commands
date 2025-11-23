<?php

namespace Ldaidone\LaravelDddCommands\Commands\Concerns;

/**
 * Trait that exposes command signature and description.
 *
 * This trait provides methods to access the signature and description
 * properties of console commands, allowing external code to retrieve
 * these values programmatically.
 *
 * @author Leo Daidone <leo.daidone@gmail.com>
 *
 * @link https://github.com/ldaidone
 * @link https://www.linkedin.com/in/leodaidone
 */
trait ExposesSignature
{
    /**
     * Get the command signature.
     *
     * @return string The command signature string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }

    /**
     * Get the command description.
     *
     * @return string The command description text
     */
    public function getDescriptionText(): string
    {
        return $this->description;
    }
}
