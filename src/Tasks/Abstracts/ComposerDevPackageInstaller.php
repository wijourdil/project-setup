<?php

namespace Wijourdil\ProjectSetup\Tasks\Abstracts;

use Wijourdil\ProjectSetup\Tasks\Contracts\Installable;

abstract class ComposerDevPackageInstaller implements Installable
{
    abstract protected function packageName(): string;

    public function install(): void
    {
        shell_exec("composer require --dev {$this->packageName()}");
    }
}
