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
        $validatedRequest = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'max:255'
        ]);

        $project = auth()->user()->projects()->create($validatedRequest);

        // redirect
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $validatedRequest = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'max:255'
        ]);

        $project->update($validatedRequest);
        // redirect
        return redirect($project->path());
    }
}
