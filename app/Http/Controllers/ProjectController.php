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
    public function store()
    {
        // validate
        $validatedRequest = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        // persist
        Project::create($validatedRequest);

        // redirect
        return redirect('/projects');
    }
}
