<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallAssertPackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallAssertPackageTest extends TestCase
{
    private const PACKAGE = 'webmozart/assert';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        Config::set('project-setup.tasks', [
            new InstallAssertPackage(),
        ]);
    }

    /** @test */
    public function it_can_install_package()
    {
        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run')->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    /** @test */
    public function it_can_reinstall_package()
    {
        (new FakePackageInstaller)->install(self::PACKAGE);

        $this->artisan('project-setup:run')
            ->expectsQuestion("Task 'Install Assert Package' seems to be already installed, would you re-install it ?", "y")
            ->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    /** @test */
    public function it_can_force_reinstall_package()
    {
        (new FakePackageInstaller)->install(self::PACKAGE);

        $this->artisan('project-setup:run --force-run')
            ->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    /** @test */
    public function it_can_force_ignore_package()
    {
        (new FakePackageInstaller)->install(self::PACKAGE);

        $this->artisan('project-setup:run --force-ignore')
            ->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }
}
