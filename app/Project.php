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
        $changes = $this->activityChanges();
        $this->activity()->create(compact('description', 'changes'));
    }

    protected function activityChanges()
    {
        if($this->wasChanged()){
            $old = $this->getOriginal();
            $new = $this->toArray();

            return $changes = [
                'before' => array_except(array_diff($old, $new), 'updated_at'),
                'after' => array_except(array_diff($new, $old), 'updated_at'),
            ];
        }
    }
}
