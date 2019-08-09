<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FavouriteThings;
use App\Medications;
use App\Contact;
class About extends Model
{
    protected $table = 'about_me';
	protected $fillable = ['user_id', 'live_place_id','work_place_id', 'email', 'contact_id' , "doctor_id" , 'emergency_id'];
    /**
     * Get the team that owns the contact.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
    }
    public function work_place()
    {
        return $this->belongsTo('App\Organisation');
    }
    public function live_place()
    {
        return $this->belongsTo('App\Organisation');
    }
    public function doctor()
    {
        return $this->belongsTo('App\Contact');
    }
    public function emergency()
    {
        return $this->belongsTo('App\Contact');
    }
    public function favouritethings(){
        $favourite_things = FavouriteThings::where("user_id",$this->user_id)->get();
        // var_dump($favourite_things);exit;
        return $favourite_things;
    }
    public function medications(){
        $medications = Medications::where("user_id",$this->user_id)->get();
        // var_dump($favourite_things);exit;
        return $medications;
    }
    public function favourite_people(){
        $ids = explode(",",$this->contact_id);
        $favourite_people = array();
        foreach($ids as $id){
            if($id == 0)continue;
            $favourite_people[] = Contact::find($id);
        }
        return $favourite_people;
    }
}
