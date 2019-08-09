<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminder';
    protected $dates = ['created_at', 'updated_at','start_date'];
    protected $fillable = ['title', 'user_id', 'start_date', 'repeat_type', 'repeat_until', "details" , 'send_sms', 'photo',"done"];
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function getSimpleDateAttribute()
    {
        return Carbon::parse($this->attributes['start_date'])->format('l,d/m/Y');
      // return substr(->format(), 0, 10); // or whatever you like to process dateTime field
    }
}
