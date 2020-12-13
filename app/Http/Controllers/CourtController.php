<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use App\Court;
use App\User;
use App\CourtComment;

class CourtController extends Controller
{
    public function index()
    {
        $courts = DB::table('courts')
            ->select('courts.*', DB::raw('count(distinct court_user.id) as users_count'), DB::raw('count(distinct court_comments.id) as comments_count'))
            ->leftJoin('court_user', 'courts.id', '=', 'court_user.court_id')
            ->leftJoin('court_comments', 'courts.id', '=', 'court_comments.court_id')
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
            'players' => $court->users()->get()->reverse(),
            'comments' => $court->comments()->get(),
        ]);
    }

    public function comment($id, Request $request)
    {
        $comment = CourtComment::create([
            'user_id' => Auth::id(),
            'court_id' => $id,
            'comment' => $request->input('comment'),
        ]);
        $comment->save();

        // send email
        $user = User::findOrFail($id);
        $sender = User::findOrFail(Auth::id());
        Mail::send('emails.court_comment', [
            'comment' => $request->input('comment'),
            'id' => $id,
        ], function($m) use ($user) {
            $m->from('no-reply@playtennis.com.ua', 'Play Tennis');
            $m->to('slicer256@gmail.com', "Alex")->subject('Play Tennis - комментарий к корту');
        });

        return redirect()->route('court', ['id' => $id])->with('success', 'Комментарий добавлен.');
    }
}
