<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class FriendsController extends Controller
{
    public function index()
    {
        $messages = DB::table('messages')
            ->select('messages.*', 'u1.name as author_name', 'u2.name as recipient_name', 'u1.avatar_image')
            ->leftJoin('users as u1', 'u1.id', 'messages.author_id')
            ->leftJoin('users as u2', 'u2.id', 'messages.recipient_id')
            ->where('author_id', Auth::id())
            ->orWhere('recipient_id', Auth::id())
            ->orderBy('id', 'desc')
            ->get();

        // filter to detect all friends
        $player_processed = [];
        $top_messages = [];
        foreach($messages as $message) {
            if ($message->author_id === Auth::id()) {
                $message->friend_id = $message->recipient_id;
                $message->friend_name = $message->recipient_name;
            }
            else {
                $message->friend_id = $message->author_id;
                $message->friend_name = $message->author_name;
            }
            if (!in_array($message->friend_id, $player_processed)) {
                $player_processed[] = $message->friend_id;
                $top_messages[] = $message;
            }
        }
        return view('friends', [
            'messages' => $top_messages,
        ]);
    }
}
