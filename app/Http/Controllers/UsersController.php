<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Interior;

class UsersController extends Controller
{
    public function users()
    {
        return view('users/users'/*, [
            'data' => [
                'users' => User::all()->get(),
            ]
            ]*/);
    }

    public function show($id)
    {
        if (\Auth::id() == $id) {
            return view('interior/myInterior');
        } else {
            return view('users/show', [
                'data' => [
                    'user' => User::with('interiors')->find($id),
                ]
            ]);
        }
    }

    public function followUser()
    {
        $user = \Auth::user();
        $interiors = $user->feed_interiors()->with('user')->orderBy('created_at', 'desc')->paginate(12);
        //$users = \Auth::user()->followings;
        return view('users/followUser', [
            'data' => [
                //'users' => $users,
                //'users2' => User::with('interior'),
                //'users3' => User::with('interior')->get(),
                'interiors' => $interiors,
                //'interiors2' => Interior::with('user')->get(),
                //'interiors' => $interiors,

            ]
        ]);
    }

    public function check($id)
    {
        $checked = \Auth::user()->is_following($id);

        if ($checked > 0) {
            return true;
        } else {
            return false;
        }
        //return \Auth::user()->is_following($id);
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
