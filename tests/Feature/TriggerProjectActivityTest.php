<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
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

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('task_created', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('new task', $activity->subject->body);
        });
    }

    /** @test */
    public function completing_a_task()
    {
        /** @var Project $project */
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks()->first()->path(), ['body' => 'maybe updated', 'completed' => true]);

        $this->assertCount(3, $project->activity);
        tap($project->activity->last(), function($activity) {
            $this->assertEquals('task_completed', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /** @test */
    public function incompleting_a_task()
    {
        /** @var Project $project */
        $project = ProjectFactory::withTasks(1)->create();
        $this->actingAs($project->owner)
            ->patch($project->tasks()->first()->path(), ['body' => 'maybe updated', 'completed' => true]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks()->first()->path(), ['body' => 'maybe updated', 'completed' => false]);

        $project->refresh();
        $this->assertCount(4, $project->activity);
        $this->assertEquals('task_incompleted', $project->activity->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        /** @var Project $project */
        $project = ProjectFactory::withTasks(1)->create();
        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activity);
        $this->assertEquals('task_deleted', $project->activity->last()->description);
    }
}
