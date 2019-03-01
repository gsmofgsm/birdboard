<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_project_has_a_path()
    {
        $project = factory('App\Project')->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function a_project_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();
        $this->assertInstanceOf(User::class, $project->owner);
    }

    /** @test */
    public function a_project_can_add_a_task()
    {
        $this->signIn();
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $task = $project->addTask('Test task');
        $this->assertCount(1, $project->tasks);
        $this->assertEquals('Test task', $project->tasks->last()->body);
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function it_can_invite_a_user()
    {
        $project = factory('App\Project')->create();

        $project->invite($newUser = factory(User::class)->create());

        $this->assertTrue($project->members->contains($newUser));
    }
}
