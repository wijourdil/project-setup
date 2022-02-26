<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Tasks\InstallAssertPackage;
use Wijourdil\ProjectSetup\Tasks\InstallAssertPhpstanRulePackage;
use Wijourdil\ProjectSetup\Tasks\InstallLarastanPackage;
use Wijourdil\ProjectSetup\Tasks\InstallPhpstanSafeRulePackage;
use Wijourdil\ProjectSetup\Tests\TestCase;

class InstallAssertPhpstanRulePackageTest extends TestCase
{
    private const PACKAGE = 'phpstan/phpstan-webmozart-assert';

    protected function setUp(): void
    {
        parent::setUp();

        FakePackageInstaller::reset();

        $this->deleteFiles(base_path('phpstan.neon'));

        Config::set('project-setup.tasks', [
            new InstallLarastanPackage(),
            new InstallAssertPackage(),
            new InstallAssertPhpstanRulePackage(),
        ]);
    }

    /** @test */
    public function it_can_install_package()
    {
        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertTrue((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    /** @test */
    public function it_cannot_install_package_without_dependencies()
    {
        Config::set('project-setup.tasks', [
            new InstallPhpstanSafeRulePackage(),
        ]);

        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));

        $this->artisan('project-setup:run --force-run --no-interaction')->assertFailed();

        $this->assertFalse((new FakePackageInstaller)->isInstalled(self::PACKAGE));
    }

    /** @test */
    public function it_can_configure_package()
    {
        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertStringContainsString(
            'vendor/phpstan/phpstan-webmozart-assert/extension.neon',
            file_get_contents(base_path('phpstan.neon'))
        );
    }

    /** @test */
    public function it_does_not_add_line_multiple_times_after_package_configuration()
    {
        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertStringContainsString(
            'vendor/phpstan/phpstan-webmozart-assert/extension.neon',
            file_get_contents(base_path('phpstan.neon'))
        );

        $this->artisan('project-setup:run --force-run --no-interaction')->assertSuccessful();

        $this->assertEquals(
            1,
            mb_substr_count(
                file_get_contents(base_path('phpstan.neon')),
                'vendor/phpstan/phpstan-webmozart-assert/extension.neon'
            )
        );
    }
}
