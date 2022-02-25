<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface Outputable
{
    public function info(string $message): void;

    public function note(string $message): void;
}
