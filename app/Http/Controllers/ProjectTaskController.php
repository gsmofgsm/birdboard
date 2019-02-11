<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);

        request()->validate([
            'body' => 'required'
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Task $task)
    {
        $this->authorize('update', $task->project);

        $task->update(request()->validate([
            'body' => 'required'
        ]));

        if(request()->has('completed')){
            $task->complete();
        }

        return redirect($task->project->path());
    }
}
