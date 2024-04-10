<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallLarastanPackage;
use Wijourdil\ProjectSetup\Tasks\InstallPhpstanSafeRulePackage;
use Wijourdil\ProjectSetup\Tasks\InstallSafePackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallPhpstanSafeRulePackageTest extends TestCase
{
    private const PACKAGE = 'thecodingmachine/phpstan-safe-rule';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles(base_path('phpstan.neon'));

        Config::set('project-setup.tasks', [
            new InstallLarastanPackage(),
            new InstallSafePackage(),
            new InstallPhpstanSafeRulePackage(),
        ]);
    }

    #[Test]
    public function it_can_install_package()
    {
        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    #[Test]
    public function it_cannot_install_package_without_dependencies()
    {
        Config::set('project-setup.tasks', [
            new InstallPhpstanSafeRulePackage(),
        ]);

        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run --force-run --no-interaction')->assertFailed();

        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    #[Test]
    public function it_can_configure_package()
    {
        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertStringContainsString(
            'vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon',
            file_get_contents(base_path('phpstan.neon'))
        );
    }

    #[Test]
    public function it_does_not_add_line_multiple_times_after_package_configuration()
    {
        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertStringContainsString(
            'vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon',
            file_get_contents(base_path('phpstan.neon'))
        );

        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertEquals(
            1,
            mb_substr_count(
                file_get_contents(base_path('phpstan.neon')),
                'vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon'
            )
        );
    }
}
