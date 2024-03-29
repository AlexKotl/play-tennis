<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Message;
use App\Http\Controllers\ProfileController;
use Auth;
use Mail;

class PlayerController extends Controller
{
    public function index(Request $request)
    {
        $players = new User;
        if ($request->input('rank_from') > 0) {
            $players = $players->where('rank', '>=', $request->input('rank_from'));
        }
        if ($request->input('rank_to') > 0) {
            $players = $players->where('rank', '<=', $request->input('rank_to'));
        }
        if ($request->input('name') != '') {
            $players = $players->where('name', 'like', '%' . $request->input('name') . '%');
        }
        $players = $players->orderBy('id', 'desc')->paginate(32)->withQueryString();

        $ranks = (new ProfileController())->getRanks();
        $ranks[''] = '';

        return view('player.index', [
            'players' => $players,
            'ranks' => $ranks,
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);
        $user->nickname = explode('@', $user->email)[0];
        $messages = [];
        $show_phone_warning = false;
        $show_phone = false;

        if (Auth::check()) {
            $auth_user_id = Auth::id();
            $messages = DB::table('messages')
                ->select('users.name as author_name', 'messages.*')
                ->leftJoin('users', 'users.id', '=', 'messages.author_id')
                ->whereIn('recipient_id', [$id, $auth_user_id])
                ->whereIn('author_id', [$id, $auth_user_id])
                ->where('recipient_id', '!=', 'author_id')
                ->orderBy('messages.id', 'desc')->get();

            // mark messages as read
            if (count($messages) > 0) {
                DB::table('messages')
                    ->where(['author_id' => $id, 'recipient_id' => Auth::id()])
                    ->update(['is_read' => true]);
            }

            // check if user sent us messages, but we have not replied yet
            $show_phone_warning = count($messages) > 0 && DB::table('messages')->where(['author_id' => Auth::id(), 'recipient_id' => $id])->count() === 0;

            // if user has replied us - we can see phone
            $show_phone = DB::table('messages')->where(['author_id' => $id, 'recipient_id' => Auth::id()])->count() > 0;

        }

        return view('player.show', [
            'player' => $user,
            'player_courts' => $user->courts()->get(),
            'messages' => $messages,
            'show_phone_warning' => $show_phone_warning,
            'show_phone' => $show_phone,
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

        // send email
        $user = User::findOrFail($id);
        $sender = User::findOrFail(Auth::id());
        Mail::send('emails.default', [
            'user' => $user,
            'sender' => $sender,
        ], function($m) use ($user) {
            $m->from('no-reply@playtennis.com.ua', 'Play Tennis');
            $m->to($user->email, $user->name)->subject('Play Tennis - нове повідомлення');
        });

        return redirect()->route('player', ['id' => $id])->with('success', 'Повідомлення відправлене.');
    }
}
