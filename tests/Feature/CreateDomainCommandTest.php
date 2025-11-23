<?php

namespace Tests\Feature;

use Ldaidone\LaravelDddCommands\Commands\CreateDomainCommand;
use PHPUnit\Framework\TestCase;

class CreateDomainCommandTest extends TestCase
{
    public function test_command_signature_and_description(): void
    {
        $command = new CreateDomainCommand;

        $this->assertStringContainsString('ddd:create-domain', $command->getSignature());
        $this->assertStringContainsString('Create a new DDD domain folder structure inside app/Domain', $command->getDescription());
    }
}
