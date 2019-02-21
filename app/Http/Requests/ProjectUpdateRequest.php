<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Support\Facades\Gate;

class ProjectUpdateRequest extends ProjectRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('update', $this->project());
    }

    public function save()
    {
        return tap($this->project())->update($this->validated());
    }

    public function delete()
    {
        $this->project()->delete();
    }

    /**
     * @return Project
     */
    public function project()
    {
        return Project::findOrFail($this->project);
    }
}
