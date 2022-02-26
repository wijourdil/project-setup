<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;

class InstallSafePackage extends InstallComposerPackage
{
    protected function packageName(): string
    {
        return 'thecodingmachine/safe';
    }

    protected function isDevDependency(): bool
    {
        return false;
    }
}
