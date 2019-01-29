<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project' ));
    }

    public function store()
    {
        // validate
        $validatedRequest = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $validatedRequest['owner_id'] = auth()->id();

        // persist
        Project::create($validatedRequest);

        // redirect
        return redirect('/projects');
    }
}
