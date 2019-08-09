<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
    protected $table = "diary";
	protected $fillable = ['appointment_id', 'note','state', 'video', 'thumbnail'];
    /**
     * Get the team that owns the contact.
     */
    public function appointment()
    {
        return $this->belongsTo('App\Appointment');
    }
    public function medias()
    {
        return $this->hasMany('App\DiaryMedia');
    }
}