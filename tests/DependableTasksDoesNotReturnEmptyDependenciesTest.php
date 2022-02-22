<?php

namespace Wijourdil\ProjectSetup\Tests;

use Illuminate\Support\Collection;
use Wijourdil\ProjectSetup\Tasks\Contracts\Dependable;

class DependableTasksDoesNotReturnEmptyDependenciesTest extends TestCase
{
    /** @test */
    public function dependable_tasks_does_not_return_empty_dependencies()
    {
        /// The classes implementing the Dependable interface MUST return a non-empty array of dependencies

        $tasksPath = setup_package_src_path('Tasks');

        $taskClassImplementingDependableInterface = (new Collection(scandir($tasksPath)))
            ->filter(function (string $item) {
                return str_ends_with($item, '.php');
            })
            ->map(function (string $item) {
                return 'Wijourdil\\ProjectSetup\\Tasks\\' . str_replace('.php', '', $item);
            })
            ->filter(function (string $item) {
                return in_array(
                    Dependable::class,
                    class_implements($item)
                );
            })
            ->toArray();

        foreach ($taskClassImplementingDependableInterface as $class) {
            $this->assertNotEmpty(
                (new $class)->dependsOn(),
                "The class $class implements the Dependable interface but returns empty dependencies array." . PHP_EOL
                . "This class must either return a non-empty array of dependencies, or not implement this interface."
            );
        }
    }
}
