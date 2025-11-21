<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\GeneratorTestCase;

class ExistingCommandsTest extends GeneratorTestCase
{
    public function test_create_domain_command()
    {
        $this->artisan('ddd:create-domain', ['name' => 'BillingDomain'])
            ->assertExitCode(0);

        $this->assertTrue(File::isDirectory(base_path('tests/temp/Domain/BillingDomain')));
        $this->assertTrue(File::exists(base_path('tests/temp/Domain/BillingDomain/README.md')));
    }

    public function test_create_entity_command()
    {
        $this->artisan('ddd:create-entity', ['name' => 'BillingEntity/User'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/BillingEntity/Entities/User.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class User', $content);
    }

    public function test_create_value_object_command()
    {
        $this->artisan('ddd:create-value-object', ['name' => 'BillingVO/Email'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/BillingVO/ValueObjects/Email.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class Email', $content);
    }

    public function test_create_use_case_command()
    {
        $this->artisan('ddd:create-use-case', ['name' => 'BillingUseCase/RegisterUser'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/BillingUseCase/UseCases/RegisterUser.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class RegisterUser', $content);
    }

    public function test_create_repository_command()
    {
        $this->artisan('ddd:create-repository', ['name' => 'BillingRepo/User'])
            ->assertExitCode(0);

        $interfacePath = base_path('tests/temp/Domain/BillingRepo/Repositories/UserRepositoryInterface.php');
        $eloquentPath = base_path('tests/temp/Infrastructure/Database/BillingRepo/Repositories/UserEloquentRepository.php');

        $this->assertTrue(File::exists($interfacePath));
        $this->assertTrue(File::exists($eloquentPath));

        $interfaceContent = File::get($interfacePath);
        $this->assertStringContainsString('interface UserRepositoryInterface', $interfaceContent);

        $eloquentContent = File::get($eloquentPath);
        $this->assertStringContainsString('class UserEloquentRepository', $eloquentContent);
    }

    public function test_create_event_command()
    {
        $this->artisan('ddd:create-event', ['name' => 'BillingEvent/UserRegistered'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/BillingEvent/Events/UserRegistered.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class UserRegistered', $content);
    }

    public function test_create_aggregate_command()
    {
        $this->artisan('ddd:create-aggregate', ['name' => 'BillingAggregate/UserAggregate'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/BillingAggregate/Aggregates/UserAggregate.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class UserAggregate', $content);
    }
}
