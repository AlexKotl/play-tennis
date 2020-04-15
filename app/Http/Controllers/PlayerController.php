<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class PlayerController extends Controller
{
    public function index()
    {
        return view('player.index', [
            'players' => User::orderBy('id', 'desc')->get()
        ]);
    }

    public function show($id)
    {

    }

    public function message($id)
    {

    }
}
