<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface HasDependencies
{
    /**
     * @return array<class-string>
     */
    public function dependsOn(): array;
}
