<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\HasDependencies;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteInFiles;

class InstallPhpstanSafeRulePackage extends InstallComposerPackage implements Configurable, HasDependencies
{
    use CanWriteInFiles;

    protected function packageName(): string
    {
        return 'thecodingmachine/phpstan-safe-rule';
    }

    protected function isDevDependency(): bool
    {
        return true;
    }

    public function dependsOn(): array
    {
        return [
            InstallLarastanPackage::class,
            InstallSafePackage::class,
        ];
    }

    public function configure(): void
    {
        $this->appendContentInFile(
            "\n    - ./vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon",
            'includes:',
            base_path('phpstan.neon')
        );
    }

    public function alreadyConfigured(): bool
    {
        return str_contains(
            (string) file_get_contents(base_path('phpstan.neon')),
            'vendor/thecodingmachine/phpstan-safe-rule/phpstan-safe-rule.neon'
        );
    }
}
