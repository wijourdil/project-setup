<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Contracts\Executable;

class CreateGithubActionsWorkflows implements Executable
{
    public function execute(): void
    {
        if (!file_exists(base_path('.github/workflows'))) {
            mkdir(base_path('.github/workflows'), 0777, true);
        }

        copy(
            setup_package_stub_path('github-actions/deploy.yml.stub'),
            base_path('.github/workflows/deploy.yml')
        );

        copy(
            setup_package_stub_path('github-actions/style-fix.yml.stub'),
            base_path('.github/workflows/style-fix.yml')
        );

        copy(
            setup_package_stub_path('github-actions/tests.yml.stub'),
            base_path('.github/workflows/tests.yml')
        );
    }

    public function alreadyExecuted(): bool
    {
        return file_exists(base_path('.github/workflows/deploy.yml')) &&
            file_exists(base_path('.github/workflows/style-fix.yml')) &&
            file_exists(base_path('.github/workflows/tests.yml'));
    }
}
