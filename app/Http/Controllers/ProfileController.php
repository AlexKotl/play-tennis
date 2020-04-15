<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function getYears()
    {
        $years = ['' => '-'];
        foreach (range(date('Y'), date('Y') - 20, -1) as $year) {
            $years[$year] = "с {$year} года";
        }
        return $years;
    }

    public function getRanks()
    {
        $ranks = ['' => '-'];
        foreach (range(10, 75, 5) as $rank) {
            $ranks[''.$rank/10] = number_format($rank/10, 1, '.', ',');
        }
        return $ranks;
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \App\User::find(\Auth::User()->id);
        return view('auth.register', [
            'user' => $user,
            'courts' => DB::table('courts')->where('flag', 1)->get(),
            'years' => $this->getYears(),
            'ranks' => $this->getRanks(),
        ]);
    }
}
