<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\CourtComment');
    }
}
