<?php

namespace Tests\Unit;

use Ldaidone\LaravelDddCommands\Generators\BaseGenerator;
use PHPUnit\Framework\TestCase;

class BaseGeneratorTest extends TestCase
{
    public function test_constructor_sets_properties_correctly(): void
    {
        $generator = $this->getMockBuilder(BaseGenerator::class)
            ->setConstructorArgs(['domain/name', 'test'])
            ->onlyMethods(['__construct'])
            ->getMockForAbstractClass();

        $reflection = new \ReflectionClass($generator);
        $typeProperty = $reflection->getProperty('type');
        $typeProperty->setAccessible(true);

        $stubPathProperty = $reflection->getProperty('stubPath');
        $stubPathProperty->setAccessible(true);

        $this->assertEquals('test', $typeProperty->getValue($generator));
        $this->assertStringEndsWith('stubs/test.stub', $stubPathProperty->getValue($generator));
    }
}