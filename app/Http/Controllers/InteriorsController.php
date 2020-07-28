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

    public function detail(Interior $interior)
    {
        return view('interior/detail', [
            'data' => [
                'interior' => $interior,
            ]
        ]);
    }
}
