<?php

namespace Tests\Feature;

use Ldaidone\LaravelDddCommands\Commands\CreateCommandCommand;
use PHPUnit\Framework\TestCase;

class CreateCommandCommandTest extends TestCase
{
    public function test_command_signature_and_description(): void
    {
        $command = new CreateCommandCommand;

        $this->assertStringContainsString('ddd:create-command', $command->getSignature());
        $this->assertStringContainsString('Create a new DDD Command class', $command->getDescription());
    }
}