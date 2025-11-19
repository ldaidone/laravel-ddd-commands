<?php

namespace Tests\Unit;

use Ldaidone\LaravelDddCommands\Generators\ValueObjectGenerator;
use PHPUnit\Framework\TestCase;

class ValueObjectGeneratorTest extends TestCase
{
    public function test_constructor_sets_properties_correctly(): void
    {
        $generator = new ValueObjectGenerator('TestDomain/TestValueObject');

        $reflection = new \ReflectionClass($generator);

        $domainProperty = $reflection->getProperty('domain');
        $domainProperty->setAccessible(true);

        $entityProperty = $reflection->getProperty('entity');
        $entityProperty->setAccessible(true);

        $this->assertEquals('TestDomain', $domainProperty->getValue($generator));
        $this->assertEquals('TestValueObject', $entityProperty->getValue($generator));
    }

    public function test_get_value_object_path_returns_correct_path(): void
    {
        $generator = new ValueObjectGenerator('TestDomain/TestValueObject');

        $path = $generator->getValueObjectPath();

        $this->assertStringContainsString('TestValueObject.php', $path);
        $this->assertStringContainsString('TestDomain', $path);
        $this->assertStringContainsString('ValueObjects', $path);
    }
}