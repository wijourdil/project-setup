<?php

namespace Wijourdil\ProjectSetup\Console\Commands;

use Illuminate\Console\Command;
use RuntimeException;
use Throwable;
use Wijourdil\ProjectSetup\Services\TaskRunner;

class SetupCommand extends Command
{
    protected $signature = 'project-setup:run 
                            {--r|force-run : Force to re-run already ran tasks}
                            {--i|force-ignore : Force to ignore already ran tasks}';

    protected $description = 'Run all tasks to install, execute and configure everything necessary to setup a project';

    public function handle(): int
    {
        if ($this->option('force-run') === true && $this->option('force-ignore') === true) {
            $this->output->error("You can't use both options --force-run and --force-ignore");

            return self::INVALID;
        }

        $runner = new TaskRunner($this->input, $this->output);

        if ($this->option('force-run') === true) {
            $runner->reRunAlreadyRanTasks();
        }
        if ($this->option('force-ignore') === true) {
            $runner->ignoreAlreadyRanTasks();
        }
        if ($this->option('no-interaction') === true) {
            $runner->withoutInteraction();
        }

        try {
            $runner->run($this->tasksToRun());
        } catch (Throwable $exception) {
            $this->output->error($exception->getMessage());

            return self::FAILURE;
        }

        return self::SUCCESS;
    }

    /**
     * @return object[]
     */
    protected function tasksToRun(): array
    {
        $tasks = config('project-setup.tasks');

        if (!is_array($tasks)) {
            throw new RuntimeException("Configuration project-setup.tasks must be an array.");
        }

        return $tasks;
    }
}
