<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserWatchController extends Controller
{
    public function store($id)
    {
        \Auth::user()->watch($id);
    }

    public function destroy($id)
    {
        \Auth::user()->unwatch($id);
    }
}
