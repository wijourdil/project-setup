<?php

namespace Wijourdil\ProjectSetup\Tests\ConceptionRules;

use Illuminate\Support\Collection;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Tasks\Contracts\HasDependencies;
use Wijourdil\ProjectSetup\Tests\TestCase;

class TasksHavingDependenciesDoesNotReturnEmptyDependenciesTest extends TestCase
{
    #[Test]
    public function tasks_having_dependencies_does_not_return_empty_dependencies()
    {
        /// The classes implementing the HasDependencies interface MUST return a non-empty array of dependencies

        $tasksPath = setup_package_src_path('Tasks');

        $taskClassImplementingInterface = (new Collection(scandir($tasksPath)))
            ->filter(function (string $item) {
                return str_ends_with($item, '.php');
            })
            ->map(function (string $item) {
                return 'Wijourdil\\ProjectSetup\\Tasks\\' . str_replace('.php', '', $item);
            })
            ->filter(function (string $item) {
                return in_array(
                    HasDependencies::class,
                    class_implements($item)
                );
            })
            ->toArray();

        foreach ($taskClassImplementingInterface as $class) {
            $this->assertNotEmpty(
                (new $class)->dependsOn(),
                "The class $class implements the HasDependencies interface but returns empty dependencies array." . PHP_EOL
                . 'This class must either return a non-empty array of dependencies, or not implement this interface.'
            );
        }
    }
}
