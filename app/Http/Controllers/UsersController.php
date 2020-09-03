<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Interior;

class UsersController extends Controller
{
    public function users()
    {
        return view('users/users');
    }

    public function show($id)
    {
        if (\Auth::id() == $id) {
            return view('interior/myInterior');
        } else {
            return view('users/show', [
                'data' => [
                    'user' => User::with('interiors')->orderBy('created_at', 'desc')->find($id),
                ]
            ]);
        }
    }

    public function followInteriors()
    {
        $user = \Auth::user();
        $interiors = $user->feed_follow_interiors()->with('user')->orderBy('created_at', 'desc')->paginate(12);
        return view('users/followInteriors', [
            'data' => [
                'interiors' => $interiors,
            ]
        ]);
    }


    public function favoriteInteriors()
    {
        $user = \Auth::user();
        $interiors = $user->favorites()->with('user')->orderBy('created_at', 'desc')->paginate(12);
        return view('users/favoriteInteriors', [
            'data' => [
                'interiors' => $interiors,
            ]
        ]);
    }

    public function watchMessages($id)
    {
        $user = \Auth::user();
        $messages = $user->watches()->where('interior_id', $id)->with('user')->orderBy('created_at', 'asc')->paginate(100);
        return $messages;
    }

    public function checkFollow($id)
    {
        $checkedFollow = \Auth::user()->is_following($id);
        return $checkedFollow;
    }

    public function checkFavo($id)
    {
        $checkedFavo = \Auth::user()->is_favorite($id);
        return $checkedFavo;
    }

    public function checkWatch($id)
    {
        $checkedWatch = \Auth::user()->is_watch($id);
        return $checkedWatch;
    }

    public function followings($id)
    {
        $user = User::find($id);
        $followings = $user->followings()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followings,
        ];

        $data += $this->counts($user);

        return view('users.followings', $data);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $followers = $user->followers()->paginate(10);

        $data = [
            'user' => $user,
            'users' => $followers,
        ];

        $data += $this->counts($user);

        return view('users.followers', $data);
    }
}
