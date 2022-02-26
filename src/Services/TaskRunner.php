<?php

namespace Wijourdil\ProjectSetup\Services;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Throwable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Executable;
use Wijourdil\ProjectSetup\Tasks\Contracts\HasDependencies;
use Wijourdil\ProjectSetup\Tasks\Contracts\Installable;
use Wijourdil\ProjectSetup\Tasks\Contracts\NeedsManualActions;

class TaskRunner
{
    use InteractsWithIO;

    /** @var class-string[] */
    private array $successfullyRanTasks = [];
    private bool $ignoreAlreadyRanTasks = false;
    private bool $reRunAlreadyRanTasks = false;
    private bool $withInteractions = true;

    public function __construct(InputInterface $input, OutputStyle $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @param object[] $tasks
     */
    public function run(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->runTask($task);
        }
    }

    public function ignoreAlreadyRanTasks(): static
    {
        $this->ignoreAlreadyRanTasks = true;

        return $this;
    }

    public function reRunAlreadyRanTasks(): static
    {
        $this->reRunAlreadyRanTasks = true;

        return $this;
    }

    public function withoutInteraction(): static
    {
        $this->withInteractions = false;

        return $this;
    }

    private function runTask(object $task): void
    {
        try {
            $this->output->title("Running task '{$this->taskTitle($task)}'");

            if ($task instanceof HasDependencies) {
                $this->checkTaskDependencies($task);
            }

            if ($task instanceof Installable) {
                $this->installTask($task);
            }

            if ($task instanceof Executable) {
                $this->executeTask($task);
            }

            if ($task instanceof Configurable) {
                $this->configureTask($task);
            }

            if ($task instanceof NeedsManualActions) {
                $this->showManualActions($task);
            }
        } catch (Throwable $exception) {
            $this->output->error('Something went wrong: ' . $exception->getMessage());
            throw $exception;
        }

        $this->successfullyRanTasks[] = $task::class;
    }

    private function installTask(Installable $task): void
    {
        $mustRun = true;

        if ($task->alreadyInstalled()) {
            $mustRun = $this->askIfTaskShouldBeRunAgain(
                "Task '{$this->taskTitle($task)}' seems to be already installed, would you re-install it ?"
            );
        }

        if ($mustRun === true) {
            $task->install();
            $this->output->info("Task '{$this->taskTitle($task)}' installed successfully!");
        } else {
            $this->output->note("Task '{$this->taskTitle($task)}' skipped.");
        }
    }

    private function executeTask(Executable $task): void
    {
        $mustRun = true;

        if ($task->alreadyExecuted()) {
            $mustRun = $this->askIfTaskShouldBeRunAgain(
                "Task '{$this->taskTitle($task)}' seems to be already executed, would you re-execute it ?",
            );
        }

        if ($mustRun) {
            $task->execute();
            $this->output->info("Task '{$this->taskTitle($task)}' executed successfully!");
        } else {
            $this->output->note("Task '{$this->taskTitle($task)}' skipped.");
        }
    }

    private function configureTask(Configurable $task): void
    {
        $mustRun = true;

        if ($task->alreadyConfigured()) {
            $mustRun = $this->askIfTaskShouldBeRunAgain(
                "Task '{$this->taskTitle($task)}' seems to be already configured, would you re-configure it ?",
            );
        }

        if ($mustRun) {
            $task->configure();
            $this->output->info("Task '{$this->taskTitle($task)}' configured successfully!");
        } else {
            $this->output->note("Task '{$this->taskTitle($task)}' skipped.");
        }
    }

    private function showManualActions(NeedsManualActions $task): void
    {
        foreach ($task->getManualActions() as $action) {
            $this->output->note($action);

            if ($this->withInteractions === true) {
                readline();
            }
        }
    }

    private function checkTaskDependencies(HasDependencies $task): void
    {
        foreach ($task->dependsOn() as $dependency) {
            if (!in_array($dependency, $this->successfullyRanTasks)) {
                throw new RuntimeException(
                    'Cannot execute task ' . $task::class
                    . " because its dependency {$dependency} was not executed before"
                );
            }
        }
    }

    private function askIfTaskShouldBeRunAgain(string $question): bool
    {
        if ($this->ignoreAlreadyRanTasks == false && $this->reRunAlreadyRanTasks == false) {
            $answer = $this->output->ask($question, 'yes/NO');
            $mustRun = in_array(mb_strtolower($answer), ['y', 'yes']);
        } else {
            $mustRun = (!$this->ignoreAlreadyRanTasks && $this->reRunAlreadyRanTasks);
        }

        return $mustRun;
    }

    private function taskTitle(object $task): string
    {
        return Str::headline(class_basename($task));
    }
}
