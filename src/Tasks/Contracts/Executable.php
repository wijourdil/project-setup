<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface Executable
{
    public function execute(): void;

    public function alreadyExecuted(): bool;
}
