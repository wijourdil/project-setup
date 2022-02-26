<?php

namespace Wijourdil\ProjectSetup\Services\PackageInstaller;

class FakePackageInstaller implements PackageInstallerContract
{
    public static function reset(): void
    {
        $_SESSION['installed-packages'] = [];
    }

    public function install(string $package, string $options = ''): void
    {
        if (!isset($_SESSION['installed-packages'])) {
            $_SESSION['installed-packages'] = [];
        }

        $_SESSION['installed-packages'][] = $package;
    }

    public function isInstalled(string $package): bool
    {
        return in_array($package, $_SESSION['installed-packages']);
    }
}
