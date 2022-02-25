<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerDevPackageInstaller;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Outputable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteToOutput;

class InstallCodeSnifferPackage extends ComposerDevPackageInstaller implements Configurable, Outputable
{
    use CanWriteToOutput;

    protected function packageName(): string
    {
        return 'squizlabs/php_codesniffer';
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path('packages/squizlabs/php_codesniffer/phpcs.xml.stub'),
            base_path('phpcs.xml')
        );

        $this->info('Generated file ' . base_path('phpcs.xml') . " for package {$this->packageName()}.");
    }
}
