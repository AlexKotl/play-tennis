<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Court;
use App\Traits\UploadTrait;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends \App\Http\Controllers\ProfileController
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar_image' =>  'image|mimes:jpeg,png,jpg,gif|max:4048',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (!array_key_exists('is_trainer', $data)) {
            $data['is_trainer'] = 0;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'rank' => $data['rank'],
            'about' => $data['about'],
            'is_trainer' => $data['is_trainer'],
            'trainer_price' => $data['trainer_price'],
            'player_since' => $data['player_since'],
        ]);

        if (isset($data['courts'])) {
            $courts = Court::find($data['courts']);
            $user->courts()->sync($courts);
        }

        if (isset($data['avatar_image'])) {
            $user->avatar_image = $this->uploadAvatar(request()->file('avatar_image'));
            $user->save();
        }

        return $user;
    }

    public function showRegistrationForm()
    {
        return view('auth.register')->with([
            'courts' => DB::table('courts')->where('flag', 1)->get(),
            'years' => $this->getYears(),
            'ranks' => $this->getRanks(),
        ]);
    }

}
