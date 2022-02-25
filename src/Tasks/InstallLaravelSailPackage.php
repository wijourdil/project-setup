<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerDevPackageInstaller;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;

class InstallLaravelSailPackage extends ComposerDevPackageInstaller implements Configurable
{
    protected function packageName(): string
    {
        return 'laravel/sail';
    }

    public function configure(): void
    {
        copy(
            setup_package_stub_path('packages/laravel/sail/docker-compose.yml.stub'),
            base_path('docker-compose.yml')
        );

        if (!file_exists(base_path('docker-init'))) {
            mkdir(base_path('docker-init'));
        }
        copy(
            setup_package_stub_path('packages/laravel/sail/docker-init/init.sql.stub'),
            base_path('docker-init/init.sql')
        );
    }
}
