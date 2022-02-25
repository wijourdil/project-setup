<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Contracts\Executable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanDetermineFramework;

class CreateMakefile implements Executable
{
    use CanDetermineFramework;

    public function execute(): void
    {
        if ($this->isLumen()) {
            $framework = 'lumen';
        } else {
            $framework = 'laravel';
        }

        copy(
            setup_package_stub_path("Makefile.$framework.stub"),
            base_path('Makefile')
        );
    }
}
