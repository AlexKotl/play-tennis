<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use View;
use App\Message;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $friends_count = 0;
        //     if (Auth::check()) {
        //         $unread_messages = Message::where([
        //             'recipient_id' => Auth::id(),
        //             'is_read' => 0,
        //         ])->get();
        //         $friends_count = count($unread_messages);
        //     }
        //     View::share('menu_friends_count', $friends_count > 0 ? $friends_count : '');

        //     return $next($request);
        // });

    }
}
