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
        $courts = DB::table('courts')
            ->select('courts.*', DB::raw('count(court_user.id) as users_count'))
            ->leftJoin('court_user', 'courts.id', '=', 'court_user.court_id')
            ->where('courts.flag', 1)
            ->groupBy('court_user.court_id')
            ->get();
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
