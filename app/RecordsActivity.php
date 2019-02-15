<?php
namespace App;

trait RecordsActivity
{
    public function registerActivity($description)
    {
        $changes = $this->activityChanges();
        $project_id = class_basename($this) === 'Project' ? $this->id : $this->project->id;
        $this->activity()->create(compact('description', 'project_id', 'changes'));
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    protected function activityChanges()
    {
        if ($this->wasChanged()) {
            $old = $this->getOriginal();
            $new = $this->toArray();

            return $changes = [
                'before' => array_except(array_diff($old, $new), 'updated_at'),
                'after' => array_except(array_diff($new, $old), 'updated_at'),
            ];
        }
    }
}