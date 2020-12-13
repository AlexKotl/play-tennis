<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class TrainerController extends Controller
{
    public function index()
    {
        return view('trainer.index', [
            'trainers' => User::orderBy('id', 'desc')->get(),
        ]);
    }

}
