<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project' ));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        // validate
        $project = auth()->user()->projects()->create($this->validateRequest());

        // redirect
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());
        // redirect
        return redirect($project->path());
    }

    /**
     * @return mixed
     */
    public function validateRequest()
    {
        $validatedRequest = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
        return $validatedRequest;
    }
}
