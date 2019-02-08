<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();
        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        $project = factory('App\Project')->create();
        $this->signIn();
        $task = factory('App\Task')->raw();
        $this->post($project->path() . '/tasks', $task)->assertForbidden();
        $this->assertDatabaseMissing('tasks', ['body' => $task['body']]);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();
        $project = factory('App\Project')->create();
//        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $task = $project->addTask('test task');
//        $this->signIn();
        $this->patch($task->path(), ['body' => 'updated'])->assertForbidden();
        $this->assertDatabaseHas('tasks', ['body' => 'test task']);
        $this->assertDatabaseMissing('tasks', ['body' => 'updated']);
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test Task.']);

        $this->get($project->path())->assertSee('Test Task.');
    }

    /** @test */
    public function a_task_be_updated()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->withTasks(1)->create();

        $attribute = [
            'body' => 'changed',
            'completed' => true
        ];

        $this->patch($project->tasks()->first()->path(), $attribute);

        $this->assertDatabaseHas('tasks', $attribute);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $attributes = factory('App\Task')->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }
}
