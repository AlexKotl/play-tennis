<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourtController extends Controller
{
    public function index()
    {
        $courts = DB::table('courts')->where('flag', 1)->get();
        return view('court.index', ['courts' => $courts]);
    }

    public function show($id)
    {
        $court = DB::table('courts')->find($id);
        return view('court.show', ['court' => $court]);
    }
}
