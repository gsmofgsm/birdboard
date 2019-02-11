<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    protected $touches = ['project'];

    protected static function boot()
    {
        parent::boot();

        static::created(function($task){
            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'task_created'
            ]);
        });

        static::updated(function($task){
            if(! $task->completed){
                return;
            }
            Activity::create([
                'project_id' => $task->project->id,
                'description' => 'task_completed'
            ]);
        });
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return '/tasks/' . $this->id;
    }
}
