<?php

namespace Wijourdil\ProjectSetup\Tasks\Contracts;

interface Dependable
{
    /**
     * @return array<class-string>
     */
    public function dependsOn(): array;
}
