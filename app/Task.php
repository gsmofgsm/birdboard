<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return '/tasks/' . $this->id;
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->registerActivity('task_completed');
    }

    public function incomplete()
    {
        $this->update(['completed' => false]);
        $this->registerActivity('task_incompleted');
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function registerActivity($description)
    {
        $project_id = $this->project->id;
        $this->activity()->create(compact('project_id', 'description'));
    }
}
