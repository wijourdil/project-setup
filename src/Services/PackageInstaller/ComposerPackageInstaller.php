<?php

namespace Wijourdil\ProjectSetup\Services\PackageInstaller;

use RuntimeException;
use Throwable;

class ComposerPackageInstaller implements PackageInstallerContract
{
    public function install(string $package, string $options = ''): void
    {
        $resultCode = 0;
        $command = "composer require $package $options";

        system($command, $resultCode);

        if ($resultCode !== 0) {
            throw new RuntimeException(
                "An error has occurred while installing package '$package' with options '$options'"
            );
        }
    }

    public function isInstalled(string $package): bool
    {
        $resultCode = 0;

        try {
            system("composer info $package > /dev/null 2> /dev/null", $resultCode);
        } catch (Throwable) {
            $resultCode = 1;
        }

        return $resultCode === 0;
    }
}
