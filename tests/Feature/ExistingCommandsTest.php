<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\GeneratorTestCase;

class ExistingCommandsTest extends GeneratorTestCase
{
    public function test_create_domain_command()
    {
        $this->artisan('ddd:create-domain', ['name' => 'User'])->assertExitCode(0);

        $domainDir = basePath('tests/temp/app/Domains/User');
        $domainREADME = basePath('tests/temp/app/Domains/User/README.md');
        $this->assertTrue(File::isDirectory($domainDir));
        $this->assertTrue(File::exists($domainREADME));
    }

    public function test_create_entity_command()
    {
        $this->artisan('ddd:create-entity', ['name' => 'Billing/User'])->assertExitCode(0);

        $path = basePath('tests/temp/app/Domains/Billing/Entities/User.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class User', $content);
    }

    public function test_create_value_object_command()
    {
        $this->artisan('ddd:create-value-object', ['name' => 'Billing/Email'])->assertExitCode(0);

        $path = basePath('tests/temp/app/Domains/Billing/ValueObjects/Email.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class Email', $content);
    }

    public function test_create_use_case_command()
    {
        $this->artisan('ddd:create-use-case', ['name' => 'Billing/RegisterUser'])->assertExitCode(0);

        $path = basePath('tests/temp/app/Domains/Billing/UseCases/RegisterUser.php');
        $this->assertTrue(File::exists($path));
        $content = File::get($path);
        $this->assertStringContainsString('class RegisterUser', $content);
    }

    public function test_create_repository_command()
    {
        $this->artisan('ddd:create-repository', ['name' => 'Billing/User'])->assertExitCode(0);

        $interfacePath = basePath('tests/temp/app/Domains/Billing/Repositories/UserRepositoryInterface.php');
        $eloquentPath = basePath('tests/temp/app/Infrastructure/Database/Billing/Repositories/UserEloquentRepository.php');

        $this->assertTrue(File::exists($interfacePath));
        $this->assertTrue(File::exists($eloquentPath));

        $interfaceContent = File::get($interfacePath);
        $this->assertStringContainsString('interface UserRepositoryInterface', $interfaceContent);

        $eloquentContent = File::get($eloquentPath);
        $this->assertStringContainsString('class UserEloquentRepository', $eloquentContent);
    }

    public function test_create_event_command()
    {
        $this->artisan('ddd:create-event', ['name' => 'Billing/UserRegistered'])->assertExitCode(0);

        $path = basePath('tests/temp/app/Domains/Billing/Events/UserRegistered.php');
        $this->assertTrue(File::exists($path), "Event file was not created at {$path}");
        $content = File::get($path);
        $this->assertStringContainsString('class UserRegistered', $content);
    }

    public function test_create_aggregate_command()
    {
        $this->artisan('ddd:create-aggregate', ['name' => 'Billing/UserAggregate'])
            ->assertExitCode(0);

        $path = basePath('tests/temp/app/Domains/Billing/Aggregates/UserAggregate.php');
        $this->assertTrue(File::exists($path), "Aggregate file was not created at {$path}");
        $content = File::get($path);
        $this->assertStringContainsString('class UserAggregate', $content);
    }
}
