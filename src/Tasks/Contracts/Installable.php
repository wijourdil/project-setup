<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface Installable
{
    public function install(): void;

    public function alreadyInstalled(): bool;
}
