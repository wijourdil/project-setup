<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallPhpCsFixerPackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallPhpCsFixerPackageTest extends TestCase
{
    private const PACKAGE = 'friendsofphp/php-cs-fixer';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles(base_path('.php-cs-fixer.dist.php'));

        Config::set('project-setup.tasks', [
            new InstallPhpCsFixerPackage(),
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
        $this->assertFileDoesNotExist(base_path('.php-cs-fixer.dist.php'));

        $this->artisan('project-setup:run --no-interaction')->assertSuccessful();

        $this->assertFileExists(base_path('.php-cs-fixer.dist.php'));
    }
}
