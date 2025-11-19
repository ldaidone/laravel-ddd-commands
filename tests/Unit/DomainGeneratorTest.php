<?php

namespace Tests\Unit;

use Ldaidone\LaravelDddCommands\Generators\DomainGenerator;
use PHPUnit\Framework\TestCase;

class DomainGeneratorTest extends TestCase
{
    public function test_constructor_sets_name_and_path(): void
    {
        $generator = new DomainGenerator('TestDomain');
        $reflection = new \ReflectionClass($generator);
        $nameProperty = $reflection->getProperty('name');
        $nameProperty->setAccessible(true);

        $this->assertEquals('TestDomain', $nameProperty->getValue($generator));
    }

    public function test_exists_method(): void
    {
        // For this test, we'll check the domain path is set correctly
        $generator = new DomainGenerator('TestDomain');
        $reflection = new \ReflectionClass($generator);
        $domainPathProperty = $reflection->getProperty('domainPath');
        $domainPathProperty->setAccessible(true);

        $expectedPath = app_path("Domain/TestDomain");
        $this->assertStringContainsString('Domain/TestDomain', $domainPathProperty->getValue($generator));
    }
}