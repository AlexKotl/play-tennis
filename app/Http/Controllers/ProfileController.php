<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Court;
use Auth;
use App\Traits\UploadTrait;

class ProfileController extends Controller
{

    use UploadTrait;

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

    public function index()
    {

        $user = Auth::User();
        return view('auth.register', [
            'user' => $user,
            'courts_checked' => $user->courts()->get()->pluck('id')->toArray(),
            'courts' => Court::where('flag', 1)->get(),
            'years' => $this->getYears(),
            'ranks' => $this->getRanks(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'avatar_image' =>  'image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);

        $user = Auth::User();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->rank = $request->input('rank');
        $user->player_since = $request->input('player_since');
        $user->about = $request->input('about');
        if ($request->has('avatar_image')) {
            $user->avatar_image = $this->uploadAvatar($request->file('avatar_image'));
        }
        $user->save();

        $courts = Court::find($request->input('courts'));
        $user->courts()->sync($courts);

        return redirect('profile')->with('success', 'Профиль сохранен.');
    }
}
