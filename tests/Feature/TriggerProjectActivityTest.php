<?php

namespace Tests\Feature;

use App\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerProjectActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity->last()->description);
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $project->update(['title' => 'Changed']);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    /** @test */
    public function creating_a_new_task()
    {
        /** @var Project $project */
        $project = ProjectFactory::create();
        $project->addTask('new task');

        $this->assertCount(2, $project->activity);
        $this->assertEquals('task_created', $project->activity->last()->description);
    }

    /** @test */
    public function completing_a_task()
    {
        /** @var Project $project */
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks()->first()->path(), ['body' => 'maybe updated', 'completed' => true]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('task_completed', $project->activity->last()->description);
    }
}
