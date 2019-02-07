<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function guests_cannot_view_projects()
    {
        $this->get('/projects')->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_view_a_specific_project()
    {
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_see_create_project_page()
    {
        $this->get('/projects/create')->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $this->get('/projects/create')->assertOk();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes here.'
        ];

        $response = $this->post('/projects', $attributes);
        $project = Project::where($attributes)->first();
        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $notes = ['notes' => 'Changed.'];
        $this->patch($project->path(), $notes);
        $this->assertDatabaseHas('projects', $notes);
        $this->get($project->path())->assertSee($notes['notes']);
    }

    /** @test */
    public function a_user_can_not_update_a_project_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $notes = ['notes' => 'Changed.'];
        $this->patch($project->path(), $notes)->assertForbidden();
    }

    /** @test */
    public function a_user_can_view_their_projects()
    {
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get( $project->path() )->assertSee($project->title)->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_projects_of_others()
    {
        $project = factory('App\Project')->create();

        $this->signIn();

        $this->get( $project->path() )->assertStatus(403);
    }

    /** @test */
    public function a_user_can_list_their_projects_but_not_projects_of_others()
    {
        $this->signIn();

        $project_of_his = factory('App\Project')->create(['owner_id' => auth()->id()]);
        $project_not_his = factory('App\Project')->create();

        $this->get('projects')->assertSee($project_of_his->title)->assertDontSee($project_not_his->title);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function guests_cannot_create_a_project()
    {
        $attributes = factory('App\Project')->raw();
        $this->post('/projects', $attributes)->assertRedirect('login');
    }
}
