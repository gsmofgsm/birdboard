<?php

namespace App\Http\Requests;

use App\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->project() ? Gate::allows('update', $this->project()) : true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ];
    }

    public function save()
    {
        if($this->project()) {
            return tap($this->project())->update($this->validated());
        }else{
            return auth()->user()->projects()->create($this->validated());
        }
    }

    /**
     * @return Project
     */
    public function project()
    {
        return $this->route('project') ? Project::findOrFail($this->route('project')) : null;
    }
}
