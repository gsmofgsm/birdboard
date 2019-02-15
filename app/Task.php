<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static $recordableEvents = ['created', 'deleted'];

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

    public function registerActivity($description)
    {
        $changes = $this->activityChanges();
        $project_id = class_basename($this) === 'Project' ? $this->id : $this->project->id;
        $this->activity()->create(compact('description', 'project_id', 'changes'));
    }

    protected function activityChanges()
    {
        return null;
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
