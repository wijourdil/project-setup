<?php

namespace Wijourdil\ProjectSetup\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    protected $signature = 'project-setup:run';

    protected $description = 'blablablabla';

    public function handle(): int
    {
        $dependencies = join(' ', config('project-setup.composer-dependencies'));
        exec("composer require $dependencies");

        $devDependencies = join(' ', config('project-setup.composer-dev-dependencies'));
        exec("composer require $devDependencies --dev");

        return self::SUCCESS;
    }
}
