<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $messages = [];
        if (Auth::check()) {
            $auth_user_id = Auth::id();
            $messages = DB::table('messages')
                ->select('users.name as author_name', 'messages.*')
                ->leftJoin('users', 'users.id', '=', 'messages.author_id')
                ->whereIn('recipient_id', [$id, $auth_user_id])
                ->whereIn('author_id', [$id, $auth_user_id])
                ->orderBy('messages.id', 'desc')->get();

            // mark messages as read
            if (count($messages) > 0) {
                DB::table('messages')
                    ->where(['author_id' => $id, 'recipient_id' => Auth::id()])
                    ->update(['is_read' => true]);
            }
        }

        return view('player.show', [
            'player' => $user,
            'player_courts' => $user->courts()->get(),
            'messages' => $messages,
        ]);
    }

    public function message($id, Request $request)
    {
        $message = Message::create([
            'author_id' => Auth::id(),
            'recipient_id' => $id,
            'text' => $request->input('text'),
        ]);
        $message->save();
        return redirect()->route('player', ['id' => $id])->with('success', 'Сообщение отправлено.');
    }
}
