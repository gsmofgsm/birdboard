<?php

namespace App\Http\Requests;


class ProjectCreateRequest extends ProjectRequest
{
    public function save()
    {
        return auth()->user()->projects()->create($this->validated());
    }
}
