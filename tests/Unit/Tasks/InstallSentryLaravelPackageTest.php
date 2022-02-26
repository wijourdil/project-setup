<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallSentryLaravelPackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallSentryLaravelPackageTest extends TestCase
{
    private const PACKAGE = 'sentry/sentry-laravel';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles(config_path('sentry.php'));

        $this->createFile(base_path('vendor/sentry/sentry-laravel/config/sentry.php'));

        Config::set('project-setup.tasks', [
            new InstallSentryLaravelPackage(),
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
        $this->assertFileDoesNotExist(config_path('sentry.php'));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertFileExists(config_path('sentry.php'));
    }
}
