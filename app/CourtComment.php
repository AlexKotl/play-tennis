<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourtComment extends Model
{
    protected $fillable = ['user_id', 'court_id', 'comment'];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

}
