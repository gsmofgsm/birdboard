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
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }

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

    public function update(Project $project)
    {
        if($project->owner->isNot(auth()->user())){
            abort(403);
        }

        $validatedRequest = request()->validate([
            'notes' => 'max:255'
        ]);

        $project->update($validatedRequest);
        // redirect
        return redirect($project->path());
    }
}
