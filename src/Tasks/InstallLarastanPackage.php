<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;

class InstallLarastanPackage extends InstallComposerPackage implements Configurable
{
    protected function packageName(): string
    {
        return 'nunomaduro/larastan';
    }

    protected function isDevDependency(): bool
    {
        return true;
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path('packages/nunomaduro/larastan/phpstan.neon.stub'),
            base_path('phpstan.neon')
        );
    }

    public function alreadyConfigured(): bool
    {
        return file_exists(base_path('phpstan.neon'));
    }
}
