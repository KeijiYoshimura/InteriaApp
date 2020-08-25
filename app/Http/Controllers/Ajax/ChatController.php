<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\MessageCreated;
use App\Events\MessageDeleted;
use Illuminate\Support\Facades\Auth;

use App\Interior;
use App\Message;

class ChatController extends Controller
{
    public function index(Request $request, Interior $interior)
    {
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

    public function destroy(Request $request, Message $message)
    {
        //$messages = Message::all();

        //$message = ['message_id' => $request->message_id];

        //$message = $request->message_id;

        // $message = $user->messages()->create([
        //     'message_id' => $request->message_id,
        //     'body' => $request->body
        // ]);

        if (\Auth::id() == $message->user_id) {
            event(new MessageCreated($message));

            $result = $message->delete();
        } else {
            return "failed!!";
        }

        event(new MessageCreated($message));

        $result = $message->delete();

        //return $message;

        // $message->delete();
        // $message = Message::where('id', $request->id)->delete();
        // $messages = Message::all();
        // return $messages;
    }
}
