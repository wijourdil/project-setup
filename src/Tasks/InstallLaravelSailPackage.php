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
        // TODO à faire :
        //  - publier le fichier docker-compose
        //  - publier le fichier init sql pour créer les bdd
    }
}
