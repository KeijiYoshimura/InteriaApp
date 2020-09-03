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
        $messages = $interior->messages();
        return $messages->with('user')->orderBy('id', 'desc')->get();
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $message = $user->messages()->create([
            'interior_id' => $request->interior_id,
            'body' => $request->body,
            'is_read' => $request->is_read,
        ]);

        try {
            event(new MessageCreated($message));
        } catch (Exception $e) {
            print($e);
        };
    }

    public function destroy(Request $request, Message $message)
    {
        if (\Auth::id() == $message->user_id) {
            event(new MessageCreated($message));

            $result = $message->delete();
        } else {
            return "failed!!";
        }
    }

    public function changeRead(Message $message)
    {
        $message->is_read = !$message->is_read;
        $message->save();
        return $message;
    }
}
