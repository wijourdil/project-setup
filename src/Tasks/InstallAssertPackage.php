<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerPackageInstaller;

class InstallAssertPackage extends ComposerPackageInstaller
{
    function packageName(): string
    {
        return 'webmozart/assert';
    }
}
