<?php

namespace Tests\Feature;

use Ldaidone\LaravelDddCommands\Commands\CreateEntityCommand;
use PHPUnit\Framework\TestCase;

class CreateEntityCommandTest extends TestCase
{
    public function test_command_signature_and_description(): void
    {
        $command = new CreateEntityCommand();

        $this->assertStringContainsString('ddd:create-entity', $command->getSignature());
        $this->assertStringContainsString('Create a new DDD Entity class', $command->getDescription());
    }
}