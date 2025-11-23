<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\GeneratorTestCase;

class CreateActionCommandTest extends GeneratorTestCase
{
    public function test_it_creates_action_file()
    {
        $this->artisan('ddd:create-action', ['name' => 'Billing/RegisterUserAction'])
            ->assertExitCode(0);

        $path = base_path('tests/temp/Domain/Billing/Actions/RegisterUserAction.php');
        $this->assertTrue(File::exists($path), "Action file was not created at {$path}");

        $content = File::get($path);
        $this->assertStringContainsString('namespace Tests\Temp\Domain\Billing\Actions;', $content);
        $this->assertStringContainsString('class RegisterUserAction', $content);
    }
}
