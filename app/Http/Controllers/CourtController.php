<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Court;
use App\User;

class CourtController extends Controller
{
    public function index()
    {
        $courts = DB::table('courts')->where('flag', 1)->get();
        return view('court.index', ['courts' => $courts]);
    }

    public function show($id)
    {
        $court = Court::find($id);
        return view('court.show', [
            'court' => $court,
            'players' => $court->users()->get()
        ]);
    }
}
