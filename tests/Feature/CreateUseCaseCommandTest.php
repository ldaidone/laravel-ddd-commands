<?php

namespace Tests\Feature;

use Ldaidone\LaravelDddCommands\Commands\CreateUseCaseCommand;
use PHPUnit\Framework\TestCase;

class CreateUseCaseCommandTest extends TestCase
{
    public function test_command_signature_and_description(): void
    {
        $command = new CreateUseCaseCommand();

        $this->assertStringContainsString('ddd:create-usecase', $command->getSignature());
        $this->assertStringContainsString('Create a new DDD UseCase structure', $command->getDescription());
    }
}