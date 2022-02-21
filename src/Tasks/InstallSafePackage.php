<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerPackageInstaller;

class InstallSafePackage extends ComposerPackageInstaller
{
    protected function packageName(): string
    {
        return 'thecodingmachine/safe';
    }
}
