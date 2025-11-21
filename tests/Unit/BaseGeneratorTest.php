<?php

namespace Tests\Unit;

use Ldaidone\LaravelDddCommands\Generators\BaseGenerator;
use Tests\GeneratorTestCase;

class BaseGeneratorTest extends GeneratorTestCase
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
        $this->assertStringEndsWith('stubs/ddd/test.stub', $stubPathProperty->getValue($generator));
    }
}
