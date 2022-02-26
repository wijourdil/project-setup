<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\HasDependencies;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteInFiles;

class InstallAssertPhpstanRulePackage extends InstallComposerPackage implements Configurable, HasDependencies
{
    use CanWriteInFiles;

    protected function packageName(): string
    {
        return 'phpstan/phpstan-webmozart-assert';
    }

    protected function isDevDependency(): bool
    {
        return true;
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
            'includes:',
            base_path('phpstan.neon')
        );
    }

    public function alreadyConfigured(): bool
    {
        return str_contains(
            file_get_contents(base_path('phpstan.neon')),
            "vendor/phpstan/phpstan-webmozart-assert/extension.neon"
        );
    }
}
