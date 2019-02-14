<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function registerActivity($description)
    {
        $old = $this->getOriginal();
        $new = $this->toArray();
        $changes = [
            'before' => array_diff($old, $new),
            'after' => array_diff($new, $old),
        ];
        $this->activity()->create(compact('description', 'changes'));
    }
}
