<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerDevPackageInstaller;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Dependable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Outputable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteInFiles;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteToOutput;

class InstallWebmozartAssertPhpstanRulePackage extends ComposerDevPackageInstaller
    implements Configurable, Dependable, Outputable
{
    use CanWriteInFiles;
    use CanWriteToOutput;

    protected function packageName(): string
    {
        return 'phpstan/phpstan-webmozart-assert';
    }

    public function dependsOn(): array
    {
        return [
            InstallAssertPackage::class,
            InstallLarastanPackage::class,
        ];
    }

    public function configure(): void
    {
        $this->appendContentInFile(
            "\n    - ./vendor/phpstan/phpstan-webmozart-assert/extension.neon",
            "includes:",
            base_path('phpstan.neon')
        );

        $this->info(
            "Configuration file " . base_path('phpstan.neon') . " had been updated for package {$this->packageName()}."
        );
    }
}
