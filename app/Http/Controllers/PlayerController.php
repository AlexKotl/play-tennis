<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;

class PlayerController extends Controller
{
    public function index()
    {
        return view('player.index', [
            'players' => User::orderBy('id', 'desc')->get(),
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $user->nickname = explode('@', $user->email)[0];
        return view('player.show', [
            'player' => $user,
            'player_courts' => $user->courts()->get(),
            'messages' => [],
        ]);
    }

    public function message($id, Request $request)
    {
        $message = Message::create([
            'author_id' => Auth::User()->id,
            'recipient_id' => $id,
            'text' => $request->input('text'),
        ]);
        $message->save();
        return redirect()->route('player', ['id' => $id])->with('success', 'Сообщение отправлено.');
    }
}
