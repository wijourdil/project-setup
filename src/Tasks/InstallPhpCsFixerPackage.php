<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;

class InstallPhpCsFixerPackage extends InstallComposerPackage implements Configurable
{
    protected function packageName(): string
    {
        return 'friendsofphp/php-cs-fixer';
    }

    protected function isDevDependency(): bool
    {
        return true;
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path('packages/friendsofphp/php-cs-fixer/php-cs-fixer.dist.php.stub'),
            base_path('.php-cs-fixer.dist.php')
        );
    }

    public function alreadyConfigured(): bool
    {
        return file_exists(base_path('.php-cs-fixer.dist.php'));
    }
}
