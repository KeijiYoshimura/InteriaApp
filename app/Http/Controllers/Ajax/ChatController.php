<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Auth;

use App\Interior;
use App\Message;

class ChatController extends Controller
{
    public function index(Request $request, Interior $interior)
    {// 新着順にメッセージ一覧を取得
        // $interior = Interior::find($request->interior_id);
        $messages = $interior->messages();
        return $messages->with('user')->orderBy('id', 'desc')->get();
        //return \App\Message::with('user')->orderBy('id', 'desc')->get();
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'interior_id' => $request->interior_id,
            'body' => $request->body
        ]);
        event(new MessageCreated($message));
    }
}
