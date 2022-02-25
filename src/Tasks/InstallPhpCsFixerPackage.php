<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerDevPackageInstaller;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Outputable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteToOutput;

class InstallPhpCsFixerPackage extends ComposerDevPackageInstaller implements Configurable, Outputable
{
    use CanWriteToOutput;

    protected function packageName(): string
    {
        return 'friendsofphp/php-cs-fixer';
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path("packages/friendsofphp/php-cs-fixer/php-cs-fixer.dist.php.stub"),
            base_path("php-cs-fixer.dist.php")
        );

        $this->info("Generated file " . base_path("php-cs-fixer.dist.php") . " for package {$this->packageName()}.");
    }
}
