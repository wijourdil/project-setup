<?php

namespace Wijourdil\ProjectSetup\Tasks\Abstracts;

use Wijourdil\ProjectSetup\Services\PackageInstaller\PackageInstallerContract;
use Wijourdil\ProjectSetup\Tasks\Contracts\Installable;

abstract class InstallComposerPackage implements Installable
{
    private PackageInstallerContract $packageInstaller;

    abstract protected function packageName(): string;

    abstract protected function isDevDependency(): bool;

    public function __construct()
    {
        $this->packageInstaller = app(PackageInstallerContract::class);
    }

    public function install(): void
    {
        $this->packageInstaller->install(
            $this->packageName(),
            $this->isDevDependency() ? '--dev' : ''
        );
    }

    public function alreadyInstalled(): bool
    {
        return $this->packageInstaller->isInstalled($this->packageName());
    }
}
