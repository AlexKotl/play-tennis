<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
