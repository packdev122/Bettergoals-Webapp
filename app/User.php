<?php

namespace App;

use Laravel\Spark\CanJoinTeams;
use Laravel\Spark\User as SparkUser;
use App\Team;
use App\About;
use App\Contact;
class User extends SparkUser
{
    use CanJoinTeams;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'emergency_phone',
        'emergency_name',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'authy_id',
        'country_code',
        'card_brand',
        'card_last_four',
        'card_country',
        'billing_address',
        'billing_address_line_2',
        'billing_city',
        'billing_zip',
        'billing_country',
        'extra_billing_information',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'date',
        'uses_two_factor_auth' => 'boolean',
    ];

    public function scopeIsPWD($query)
    {
        return $query->where('pwd', 1);
    }
    public function hasPhoto(){
        $result = true;
        if(!$this->photo_url)$result = false;
        if (strpos($this->photo_url, 'www.gravatar.com/avatar/') !== false) {
            $result = false;
        }
        return $result;
    }
    public function ownTeam(){
        $team = Team::where("owner_id" , $this->id)->first();
        return $team;
    }
    public function currentTeamName(){
        $team_name = strtolower($this->currentTeam->name);
        return str_replace(' ','',$team_name);
    }
    public function emergencyContact(){
        $about = About::where('user_id', $this->id)->first();
        if(!$about)return new Contact;
        if(!$about->emergency)return new Contact;
        return $about->emergency;
    }
}
