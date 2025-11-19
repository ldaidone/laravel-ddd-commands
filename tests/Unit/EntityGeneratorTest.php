<?php

namespace Tests\Unit;

use Ldaidone\LaravelDddCommands\Generators\EntityGenerator;
use PHPUnit\Framework\TestCase;

class EntityGeneratorTest extends TestCase
{
    public function test_constructor_sets_properties_correctly(): void
    {
        $generator = new EntityGenerator('TestDomain/TestEntity');

        $reflection = new \ReflectionClass($generator);

        $domainProperty = $reflection->getProperty('domain');
        $domainProperty->setAccessible(true);

        $entityProperty = $reflection->getProperty('entity');
        $entityProperty->setAccessible(true);

        $this->assertEquals('TestDomain', $domainProperty->getValue($generator));
        $this->assertEquals('TestEntity', $entityProperty->getValue($generator));
    }

    public function test_get_entity_path_returns_correct_path(): void
    {
        $generator = new EntityGenerator('TestDomain/TestEntity');

        $path = $generator->getEntityPath();

        $this->assertStringContainsString('TestEntity.php', $path);
        $this->assertStringContainsString('TestDomain', $path);
    }
}