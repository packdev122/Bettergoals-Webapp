<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiaryMedia extends Model
{
    protected $table = "diary_media";
	protected $fillable = ['diary_id', 'video','thumbnail'];
    /**
     * Get the team that owns the contact.
     */
}