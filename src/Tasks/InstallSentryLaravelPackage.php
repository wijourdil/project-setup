<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Abstracts\ComposerPackageInstaller;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Outputable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanDetermineFramework;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteToOutput;

class InstallSentryLaravelPackage extends ComposerPackageInstaller implements Configurable, Outputable
{
    use CanDetermineFramework;
    use CanWriteToOutput;

    protected function packageName(): string
    {
        return 'sentry/sentry-laravel';
    }

    public function configure(): void
    {
        copy(
            base_path("vendor/sentry/sentry-laravel/config/sentry.php"),
            config_path("sentry.php")
        );

        $this->remind();
    }

    private function remind(): void
    {
        $this->note([
            "Before continuing, you need to manually do the following things:",
            $this->isLumen()
                ? "Please follow instructions here: https://docs.sentry.io/platforms/php/guides/laravel/other-versions/lumen, then type Enter..."
                : "Please follow instructions here: https://docs.sentry.io/platforms/php/guides/laravel, then type Enter...",
        ]);

        readline();
    }
}
