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

    protected function deleteFiles(array|string $filenames): void
    {
        foreach ((array)$filenames as $filename) {
            if (file_exists($filename)) {
                unlink($filename);
            }
        }
    }

    protected function createFile(string $filename, string $content = ''): void
    {
        if (!file_exists(pathinfo($filename, PATHINFO_DIRNAME))) {
            mkdir(pathinfo($filename, PATHINFO_DIRNAME), 0777, true);
        }

        file_put_contents($filename, $content);
    }
}
