<?php

namespace Tests\Unit;

use Ldaidone\LaravelDddCommands\Generators\UseCaseGenerator;
use PHPUnit\Framework\TestCase;

class UseCaseGeneratorTest extends TestCase
{
    public function test_constructor_sets_properties_correctly(): void
    {
        $generator = new UseCaseGenerator('TestDomain/TestUseCase');

        $reflection = new \ReflectionClass($generator);

        $domainProperty = $reflection->getProperty('domain');
        $domainProperty->setAccessible(true);

        $entityProperty = $reflection->getProperty('entity');
        $entityProperty->setAccessible(true);

        $this->assertEquals('TestDomain', $domainProperty->getValue($generator));
        $this->assertEquals('TestUseCase', $entityProperty->getValue($generator));
    }

    public function test_get_use_case_path_returns_correct_path(): void
    {
        $generator = new UseCaseGenerator('TestDomain/TestUseCase');

        $path = $generator->getUseCasePath();

        $this->assertStringContainsString('TestUseCase.php', $path);
        $this->assertStringContainsString('TestDomain', $path);
        $this->assertStringContainsString('UseCases', $path);
    }
}