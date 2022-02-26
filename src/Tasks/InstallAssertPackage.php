<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;

class InstallAssertPackage extends InstallComposerPackage
{
    protected function packageName(): string
    {
        return 'webmozart/assert';
    }

    protected function isDevDependency(): bool
    {
        return false;
    }
}
