<?php

namespace Tests\Feature;

use Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function creating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
    }
}
