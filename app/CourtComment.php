<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourtComment extends Model
{
    protected $fillable = ['user_id', 'court_id', 'comment'];
}
