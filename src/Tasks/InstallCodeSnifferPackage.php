<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;

class InstallCodeSnifferPackage extends InstallComposerPackage implements Configurable
{
    protected function packageName(): string
    {
        return 'squizlabs/php_codesniffer';
    }

    protected function isDevDependency(): bool
    {
        return true;
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path('packages/squizlabs/php_codesniffer/phpcs.xml.stub'),
            base_path('phpcs.xml')
        );
    }

    public function alreadyConfigured(): bool
    {
        return file_exists(base_path('phpcs.xml'));
    }
}
