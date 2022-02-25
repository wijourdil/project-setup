<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Contracts\Executable;
use Wijourdil\ProjectSetup\Tasks\Traits\CanWriteToOutput;

class CreateGithubActionsWorkflows implements Executable
{
    use CanWriteToOutput;

    public function execute(): void
    {
        if (!file_exists(base_path(".github/workflows"))) {
            mkdir(base_path(".github/workflows"), 0777, true);
        }

        copy(
            setup_package_stub_path("github-actions/deploy.yml.stub"),
            base_path(".github/workflows/deploy.yml")
        );

        copy(
            setup_package_stub_path("github-actions/style-fix.yml.stub"),
            base_path(".github/workflows/style-fix.yml")
        );

        copy(
            setup_package_stub_path("github-actions/tests.yml.stub"),
            base_path(".github/workflows/tests.yml")
        );

        $this->info("Generated Github Actions files in " . base_path(".github/workflows") . ".");
    }
}
