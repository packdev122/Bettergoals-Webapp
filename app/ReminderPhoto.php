<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReminderPhoto extends Model
{

    protected $table = "reminder_photos";
	protected $fillable = ['reminder_id','photo'];

    /**
     * Get the appointment that owns the photo.
     */
    public function reminder()
    {
        return $this->belongsTo('App\Reminder');
    }
}
