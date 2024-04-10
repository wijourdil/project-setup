<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallCodeSnifferPackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallCodeSnifferPackageTest extends TestCase
{
    private const PACKAGE = 'squizlabs/php_codesniffer';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles(base_path('phpcs.xml'));

        Config::set('project-setup.tasks', [
            new InstallCodeSnifferPackage(),
        ]);
    }

    #[Test]
    public function it_can_install_package()
    {
        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    #[Test]
    public function it_can_configure_package()
    {
        $this->assertFileDoesNotExist(base_path('phpcs.xml'));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertFileExists(base_path('phpcs.xml'));
    }
}
