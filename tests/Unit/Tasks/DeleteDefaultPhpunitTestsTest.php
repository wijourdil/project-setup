<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use Wijourdil\ProjectSetup\Tasks\DeleteDefaultPhpunitTests;
use Wijourdil\ProjectSetup\Tests\TestCase;

class DeleteDefaultPhpunitTestsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->createFile(base_path('tests/Feature/ExampleTest.php'));
        $this->createFile(base_path('tests/Unit/ExampleTest.php'));

        Config::set('project-setup.tasks', [
            new DeleteDefaultPhpunitTests(),
        ]);
    }

    /** @test */
    public function it_can_delete_default_phpunit_tests()
    {
        $this->assertFileExists(base_path('tests/Feature/ExampleTest.php'));
        $this->assertFileExists(base_path('tests/Unit/ExampleTest.php'));

        $this->artisan('project-setup:run')->assertSuccessful();

        $this->assertFileDoesNotExist(base_path('tests/Feature/ExampleTest.php'));
        $this->assertFileDoesNotExist(base_path('tests/Unit/ExampleTest.php'));
    }
}
