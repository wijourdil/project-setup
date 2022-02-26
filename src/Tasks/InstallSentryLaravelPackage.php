<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\InstallComposerPackage;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\NeedsManualActions;
use Wijourdil\ProjectSetup\Tasks\Traits\CanDetermineFramework;

class InstallSentryLaravelPackage extends InstallComposerPackage implements Configurable, NeedsManualActions
{
    use CanDetermineFramework;

    protected function packageName(): string
    {
        return 'sentry/sentry-laravel';
    }

    protected function isDevDependency(): bool
    {
        return false;
    }

    public function configure(): void
    {
        copy(
            base_path('vendor/sentry/sentry-laravel/config/sentry.php'),
            config_path('sentry.php')
        );
    }

    public function alreadyConfigured(): bool
    {
        return file_exists(config_path('sentry.php'));
    }

    public function getManualActions(): array
    {
        return [
            [
                'Before continuing, you need to manually do the following things:',
                $this->isLumen()
                    ? 'Please follow instructions here: https://docs.sentry.io/platforms/php/guides/laravel/other-versions/lumen, then type Enter...'
                    : 'Please follow instructions here: https://docs.sentry.io/platforms/php/guides/laravel, then type Enter...',
            ],
        ];
    }
}
