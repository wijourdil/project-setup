<?php

use Wijourdil\ProjectSetup\Tasks\CreateGithubActionsWorkflows;
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
use Wijourdil\ProjectSetup\Tasks\InstallAssertPhpstanRulePackage;

return [
    'tasks' => [
        // Code quality & tools
        new InstallAssertPackage(),
        new InstallLarastanPackage(),
        new InstallSafePackage(),
        new InstallCodeSnifferPackage(),
        new InstallPhpCsFixerPackage(),
        new InstallPhpstanSafeRulePackage(),
        new InstallAssertPhpstanRulePackage(),

        // Error handling
        new InstallSentryLaravelPackage(),

        // Dev environment
        new InstallLaravelSailPackage(),

        // Prepare project files
        new CreateMakefile(),
        new CreateGithubActionsWorkflows(),
        new DeleteDefaultPhpunitTests(),
    ],
];
