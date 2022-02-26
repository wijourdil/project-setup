<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use Wijourdil\ProjectSetup\Tasks\CreateMakefile;
use Wijourdil\ProjectSetup\Tests\TestCase;

class CreateMakefileTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteFiles(base_path('Makefile'));

        Config::set('project-setup.tasks', [
            new CreateMakefile(),
        ]);
    }

    /** @test */
    public function it_can_create_makefile()
    {
        $this->assertFileDoesNotExist(base_path('Makefile'));

        $this->artisan('project-setup:run')->assertSuccessful();

        $this->assertFileExists(base_path('Makefile'));
    }

    /** @test */
    public function it_can_overwrite_makefile_if_it_exists()
    {
        $this->createFile(base_path('Makefile'), 'test');

        $this->artisan('project-setup:run --force-run')->assertSuccessful();

        $this->assertFileEquals(
            setup_package_stub_path('makefile/Makefile.laravel.stub'),
            base_path('Makefile'),
        );
    }

    /** @test */
    public function it_does_not_overwrite_makefile_if_it_exists_if_ignore()
    {
        $this->createFile(base_path('Makefile'), 'test');

        $this->artisan('project-setup:run --force-ignore')->assertSuccessful();

        $this->assertStringEqualsFile(base_path('Makefile'), 'test');
    }
}
