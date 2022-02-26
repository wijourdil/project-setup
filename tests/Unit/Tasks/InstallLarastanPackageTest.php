<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallLarastanPackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallLarastanPackageTest extends TestCase
{
    private const PACKAGE = 'nunomaduro/larastan';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles(base_path('phpstan.neon'));

        Config::set('project-setup.tasks', [
            new InstallLarastanPackage(),
        ]);
    }

    /** @test */
    public function it_can_install_package()
    {
        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    /** @test */
    public function it_can_configure_package()
    {
        $this->assertFileDoesNotExist(base_path('phpstan.neon'));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertFileExists(base_path('phpstan.neon'));
    }
}
