<?php

namespace Wijourdil\ProjectSetup;

use Illuminate\Support\ServiceProvider;
use Wijourdil\ProjectSetup\Console\Commands\SetupCommand;
use Wijourdil\ProjectSetup\Services\PackageInstaller\ComposerPackageInstaller;
use Wijourdil\ProjectSetup\Services\PackageInstaller\FakePackageInstaller;
use Wijourdil\ProjectSetup\Services\PackageInstaller\PackageInstallerContract;

class ProjectSetupServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        if ($this->app->environment('testing')) {
            $this->app->bind(PackageInstallerContract::class, FakePackageInstaller::class);
        } else {
            $this->app->bind(PackageInstallerContract::class, ComposerPackageInstaller::class);
        }

        $this->mergeConfigFrom(
            __DIR__ . '/../config/project-setup.php',
            'project-setup'
        );
    }
}
