<?php

namespace Tests\Feature;

use Ldaidone\LaravelDddCommands\Commands\CreateQueryCommand;
use PHPUnit\Framework\TestCase;

class CreateQueryCommandTest extends TestCase
{
    public function test_command_signature_and_description(): void
    {
        $command = new CreateQueryCommand;

        $this->assertStringContainsString('ddd:create-query', $command->getSignature());
        $this->assertStringContainsString('Create a new DDD Query class', $command->getDescription());
    }
}
