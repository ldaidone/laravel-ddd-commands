<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Tests\GeneratorTestCase;

class CreateActionCommandTest extends GeneratorTestCase
{
    public function test_it_creates_action_file()
    {
        $this->artisan('ddd:create-action', ['name' => 'Billing/RegisterUserAction'])->assertExitCode(0);

        $path = basePath('tests/temp/app/Domains/Billing/Actions/RegisterUserAction.php');
        $this->assertTrue(File::exists($path), "Action file was not created at {$path}");

        $content = File::get($path);
        $this->assertStringContainsString('namespace Tests\Temp\App\Domains\Billing\Actions;', $content);
        $this->assertStringContainsString('class RegisterUserAction', $content);
    }
}
