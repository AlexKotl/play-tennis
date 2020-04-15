<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomepageController extends Controller
{
    public function index()
    {
        return view('homepage', [
            'players' => User::orderBy('id', 'desc')->limit(6)->get(),
        ]);
    }
}
