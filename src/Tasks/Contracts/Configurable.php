<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface Configurable
{
    public function configure(): void;

    public function alreadyConfigured(): bool;
}
