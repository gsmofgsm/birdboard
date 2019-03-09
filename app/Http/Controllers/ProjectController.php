<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->accessibleProjects();
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

    public function store(ProjectCreateRequest $form)
    {
        return redirect($form->save()->path());
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    public function update(ProjectUpdateRequest $form)
    {
        return redirect($form->save()->path());
    }

    public function destroy(ProjectUpdateRequest $form)
    {
        $form->delete();
        return redirect('/projects');
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
