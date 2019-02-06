<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_task_belongs_to_a_project()
    {
        $task = factory('App\Task')->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function a_task_has_a_path()
    {
        $task = factory('App\Task')->create();
        $this->assertEquals($task->project->path() . '/tasks/' . $task->id, $task->path());
    }
}
