<?php

namespace Tests\Setup;

use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{
    protected $taskCount = 0;
    protected $owner = null;

    public function ownedBy(User $user)
    {
        $this->owner = $user;
        return $this;
    }

    public function withTasks($count)
    {
        $this->taskCount = $count;

        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->owner ? $this->owner->id : factory(User::class)
        ]);

        factory(Task::class, $this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}