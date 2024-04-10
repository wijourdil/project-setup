<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
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

    #[Test]
    public function it_can_install_package()
    {
        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run')->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    #[Test]
    public function it_can_reinstall_package()
    {
        (new FakePackageInstaller)->install(self::PACKAGE);

        $this->artisan('project-setup:run')
            ->expectsQuestion("Task 'Install Assert Package' seems to be already installed, would you re-install it ?", 'y')
            ->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    #[Test]
    public function it_can_force_reinstall_package()
    {
        (new FakePackageInstaller)->install(self::PACKAGE);

        $this->artisan('project-setup:run --force-run')
            ->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    #[Test]
    public function it_can_force_ignore_package()
    {
        (new FakePackageInstaller)->install(self::PACKAGE);

        $this->artisan('project-setup:run --force-ignore')
            ->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }
}
