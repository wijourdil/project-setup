<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Tasks;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Tasks\CreateGithubActionsWorkflows;
use Wijourdil\ProjectSetup\Tests\TestCase;

class CreateGithubActionsWorkflowsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->deleteFiles([
            base_path('.github/workflows/deploy.yml'),
            base_path('.github/workflows/tests.yml'),
        ]);

        Config::set('project-setup.tasks', [
            new CreateGithubActionsWorkflows(),
        ]);
    }

    #[Test]
    public function it_can_create_github_actions_workflows_files()
    {
        $this->assertFileDoesNotExist(base_path('.github/workflows/deploy.yml'));
        $this->assertFileDoesNotExist(base_path('.github/workflows/tests.yml'));

        $this->artisan('project-setup:run')->assertSuccessful();

        $this->assertFileExists(base_path('.github/workflows/deploy.yml'));
        $this->assertFileExists(base_path('.github/workflows/tests.yml'));
    }
}
