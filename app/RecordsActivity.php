<?php
namespace App;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        foreach(self::recordableEvents() as $event) {
            static::$event(function($model) use ($event) {
                $event_description = class_basename($model) === 'Project' ? $event : strtolower(class_basename($model)) . '_' . $event;
                $model->registerActivity($event_description);
            });
        }
    }

    /**
     * @return array
     */
    public static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return static::$recordableEvents;
        }
        return ['created', 'updated', 'deleted'];
    }

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