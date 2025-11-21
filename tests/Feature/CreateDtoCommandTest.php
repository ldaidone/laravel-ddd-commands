<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\GeneratorTestCase;

class CreateDtoCommandTest extends GeneratorTestCase
{
    public function test_it_creates_dto_file()
    {
        $this->artisan('ddd:create-dto', ['name' => 'Billing/UserDto'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/Billing/DataTransferObjects/UserDto.php');
        $this->assertTrue(File::exists($path), "DTO file was not created at {$path}");

        $content = File::get($path);
        $this->assertStringContainsString('namespace Tests\Temp\Domain\Billing\DataTransferObjects;', $content);
        $this->assertStringContainsString('class UserDto', $content);
    }
}
