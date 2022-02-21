<?php

namespace Wijourdil\ProjectSetup\Tasks;

use Wijourdil\ProjectSetup\Tasks\Contracts\Executable;

class DeleteDefaultPhpunitTests implements Executable
{
    public function execute(): void
    {
        if (file_exists(base_path('tests/Feature/ExampleTest.php'))) {
            unlink(base_path('tests/Feature/ExampleTest.php'));
        }

        if (file_exists(base_path('tests/Unit/ExampleTest.php'))) {
            unlink(base_path('tests/Unit/ExampleTest.php'));
        }
    }
}
