<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interior;

class InteriorsController extends Controller
{
    public function top()
    {
        if (\Auth::check()) {
            return view('interior/top');
        } else {
            return view('welcome');
        }
    }

    public function new()
    {
        return view('interior/new');
    }

    public function chat()
    {
        return view('interior/chat');
    }

    public function mine()
    {
        return view('interior/myInterior');
    }

    public function detail($id)
    {
        return view('interior/detail', [
            'data' => [
                'interior' => Interior::with('user')->find($id),
                'interior2' => Interior::find($id)->with('user')->get(),
            ]
        ]);
    }

    public function edit(Interior $interior)
    {
        return view('interior/edit', [
            'data' => [
                'interior' => $interior,
            ]
        ]);
    }
}
