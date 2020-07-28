<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
