<?php


namespace App;


use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

trait RecordsActivity
{
    /**
     * The project's oldAttributes attributes
     *
     * @var array
     */
    public $oldAttributes = [];

    /**
     * Boot the trait
     */
    public static function bootRecordsActivity()
    {
        foreach (self::recordableEvents() as $event){
            static::$event(function ($model) use ($event){

                $model->recordActivity($model->activityDescription($event));
            });

            if($event == 'updated') {
                static::updating(function ($model) {
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }
    }

    /**
     * Get the description of activity
     *
     * @param $description
     * @return string
     */
    protected function activityDescription($description)
    {
        return "{$description}_" . strtolower(class_basename($this));
    }

    /**
     * Fetch the model events that should trigger activity
     *
     * @return array
     */
    protected static function recordableEvents(): array
    {
        if (isset(static::$recordableEvents)) {
            return $recordableEvents = static::$recordableEvents;
        }

        return $recordableEvents = ['created', 'updated'];

    }

    /**
     * Record activity for a project
     *
     * @param $description
     */

    public function recordActivity($description)
    {
        $this->activity()->create([
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'user_id' =>  ($this->project ?? $this)->owner->id,
            'description' => $description,
            'changes' => $this->activityChanges()
        ]);
    }

    /**
     * Fetch the changes to the model
     *
     * @return array | null
     */
    public function activityChanges()
    {
        if($this->wasChanged())
            return [
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(), 'updated_at')
            ];
        else
            return null;
    }

    /**
     * The activity feed for the project
     *
     * @return MorphMany
     */
    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject')->latest();
    }
}

