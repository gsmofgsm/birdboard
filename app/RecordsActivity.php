<?php
namespace App;

trait RecordsActivity
{
    public static function bootRecordsActivity()
    {
        foreach(self::recordableEvents() as $event) {
            static::$event(function($model) use ($event) {
                $model->registerActivity($model->eventDescription($event));
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

    public function eventDescription($event)
    {
        return strtolower(class_basename($this)) . '_' . $event;
    }

    public function registerActivity($description)
    {
        $changes = $this->activityChanges();
        $project = $this->project ?? $this;
        $project_id = $project->id;
        $user_id = $project->owner->id;
        $this->activity()->create(compact('description', 'user_id', 'project_id', 'changes'));
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