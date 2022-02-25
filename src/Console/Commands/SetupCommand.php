<?php

namespace Wijourdil\ProjectSetup\Console\Commands;

use Illuminate\Console\Command;
use Wijourdil\ProjectSetup\Services\TaskRunner;
use Wijourdil\ProjectSetup\Tasks\CreateMakefile;
use Wijourdil\ProjectSetup\Tasks\DeleteDefaultPhpunitTests;
use Wijourdil\ProjectSetup\Tasks\InstallAssertPackage;
use Wijourdil\ProjectSetup\Tasks\InstallCodeSnifferPackage;
use Wijourdil\ProjectSetup\Tasks\InstallLarastanPackage;
use Wijourdil\ProjectSetup\Tasks\InstallLaravelSailPackage;
use Wijourdil\ProjectSetup\Tasks\InstallPhpCsFixerPackage;
use Wijourdil\ProjectSetup\Tasks\InstallPhpstanSafeRulePackage;
use Wijourdil\ProjectSetup\Tasks\InstallSafePackage;
use Wijourdil\ProjectSetup\Tasks\InstallSentryLaravelPackage;
use Wijourdil\ProjectSetup\Tasks\InstallWebmozartAssertPhpstanRulePackage;

class SetupCommand extends Command
{
    protected $signature = 'project-setup:run';

    protected $description = 'blablablabla';

    public function handle(): int
    {
        (new TaskRunner())->run($this->tasksToRun());

        return self::SUCCESS;
    }

    /**
     * @return object[]
     */
    protected function tasksToRun(): array
    {
        return [
            // Code quality & tools
            new InstallAssertPackage(),
            new InstallLarastanPackage(),
            new InstallSafePackage(),
            new InstallCodeSnifferPackage(),
            new InstallPhpCsFixerPackage(),
            new InstallPhpstanSafeRulePackage(),
            new InstallWebmozartAssertPhpstanRulePackage(),

            // Error handling
            new InstallSentryLaravelPackage(),

            // Dev environment
            new InstallLaravelSailPackage(),

            // Prepare project files
            new CreateMakefile(),
            new DeleteDefaultPhpunitTests(),
        ];
    }
}
