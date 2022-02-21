<?php

namespace Wijourdil\ProjectSetup\Services;

use Illuminate\Console\Concerns\InteractsWithIO;
use Illuminate\Console\OutputStyle;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Configurable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Dependable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Executable;
use Wijourdil\ProjectSetup\Tasks\Contracts\Installable;

class TaskRunner
{
    use InteractsWithIO;

    /** @var object[] */
    protected array $executedTasks = [];

    public function __construct()
    {
        $this->input = new ArgvInput();
        $this->output = new OutputStyle(
            $this->input,
            new ConsoleOutput()
        );
    }

    /**
     * @param object[] $tasks
     * @return void
     */
    public function run(array $tasks): void
    {
        foreach ($tasks as $task) {
            $this->runTask($task);
        }
    }

    protected function runTask(object $task): void
    {
        try {
            $title = Str::headline(class_basename($task));
            $this->output->title("Executing task '$title'");

            if ($task instanceof Dependable) {
                $this->checkTaskDependencies($task);
            }

            if ($task instanceof Installable) {
                $task->install();
            }

            if ($task instanceof Executable) {
                $task->execute();
            }

            if ($task instanceof Configurable) {
                $task->configure();
            }

            $this->output->info("Task '$title' executed successfully!");
        } catch (Throwable $exception) {
            $this->output->error("Something went wrong: " . $exception->getMessage());
            throw $exception;
        }

        $this->executedTasks[] = $task::class;
    }

    protected function checkTaskDependencies(object $task): void
    {
        foreach ($task->dependsOn() as $dependency) {
            if (!in_array($dependency, $this->executedTasks)) {
                throw new RuntimeException(
                    "Cannot execute task " . $task::class . " because its dependency {$dependency} was not executed before"
                );
            }
        }
    }
}
