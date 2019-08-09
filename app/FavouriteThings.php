<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavouriteThings extends Model
{
    protected $table = 'favourite_things';
    protected $fillable = ['user_id', 'name','photo'];
    /**
     * Get the team that owns the contact.
     */
}
