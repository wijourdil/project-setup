<?php

namespace Wijourdil\ProjectSetup\Tests\Unit\Command;

use Illuminate\Support\Facades\Config;
use PHPUnit\Framework\Attributes\Test;
use Wijourdil\ProjectSetup\Tests\TestCase;

class SetupCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('project-setup.tasks', []);
    }

    #[Test]
    public function it_throws_an_error_if_both_options_are_used()
    {
        $this->artisan('project-setup:run --force-run --force-ignore')->assertFailed();
    }
}
