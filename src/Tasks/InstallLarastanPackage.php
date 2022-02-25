<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerDevPackageInstaller;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Outputable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteToOutput;

class InstallLarastanPackage extends ComposerDevPackageInstaller implements Configurable, Outputable
{
    use CanWriteToOutput;

    protected function packageName(): string
    {
        return 'nunomaduro/larastan';
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path('packages/nunomaduro/larastan/phpstan.neon.stub'),
            base_path('phpstan.neon')
        );

        $this->info('Generated file ' . base_path('phpstan.neon') . " for package {$this->packageName()}.");
    }
}
