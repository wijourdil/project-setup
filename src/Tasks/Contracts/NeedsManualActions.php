<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface NeedsManualActions
{
    /**
     * @return string[]|array<string[]>
     */
    public function getManualActions(): array;
}
