<?php

namespace Wijourdil\ProjectSetup\Services\PackageInstaller;

interface PackageInstallerContract
{
    public function install(string $package, string $options = ''): void;

    public function isInstalled(string $package): bool;
}
