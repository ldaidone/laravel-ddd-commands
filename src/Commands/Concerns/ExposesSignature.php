<?php

namespace Ldaidone\LaravelDddCommands\Commands\Concerns;

trait ExposesSignature
{
    public function getSignature(): string
    {
        return $this->signature;
    }

    public function getDescriptionText(): string
    {
        return $this->description;
    }
}
