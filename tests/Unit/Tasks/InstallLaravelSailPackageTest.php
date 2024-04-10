<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallLaravelSailPackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallLaravelSailPackageTest extends TestCase
{
    private const PACKAGE = 'laravel/sail';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles([
            base_path('docker-compose.yml'),
            base_path('docker-init/init.sql'),
        ]);

        Config::set('project-setup.tasks', [
            new InstallLaravelSailPackage(),
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
        $this->assertFileDoesNotExist(base_path('docker-compose.yml'));
        $this->assertFileDoesNotExist(base_path('docker-init/init.sql'));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertFileExists(base_path('docker-compose.yml'));
        $this->assertFileExists(base_path('docker-init/init.sql'));
    }
}
