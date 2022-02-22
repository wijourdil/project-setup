<?php

namespace Wijourdil\ProjectSetup\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Wijourdil\ProjectSetup\ProjectSetupServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ProjectSetupServiceProvider::class,
        ];
    }
}
