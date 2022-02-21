<?php

namespace Wijourdil\ProjectSetup;

use Illuminate\Support\ServiceProvider;
use Wijourdil\ProjectSetup\Console\Commands\SetupCommand;

class ProjectSetupServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SetupCommand::class,
            ]);
        }
    }

    public function register(): void
    {
    }
}
