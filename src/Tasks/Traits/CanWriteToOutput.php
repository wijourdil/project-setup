<?php

namespace Wijourdil\ProjectSetup\Tasks\Traits;

use Illuminate\Console\OutputStyle;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

trait CanWriteToOutput
{
    public function info(array|string $message): void
    {
        $this->getOutput()->info($message);
    }

    public function note(array|string $message): void
    {
        $this->getOutput()->note($message);
    }

    private function getOutput(): OutputStyle
    {
        return new OutputStyle(
            new ArgvInput(),
            new ConsoleOutput()
        );
    }
}
