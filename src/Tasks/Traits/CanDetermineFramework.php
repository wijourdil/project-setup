<?php

namespace Wijourdil\ProjectSetup\Tasks\Traits;

trait CanDetermineFramework
{
    private function isLumen(): bool
    {
        return str_contains(app()->version(), 'Lumen');
    }
}
