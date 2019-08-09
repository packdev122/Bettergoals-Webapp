<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medications extends Model
{
    protected $table = 'medications';
    protected $fillable = ['user_id', 'name','photo'];
    /**
     * Get the team that owns the contact.
     */
}
