<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserFavoriteController extends Controller
{
    public function store($id)
    {
        \Auth::user()->favo($id);
    }

    public function destroy($id)
    {
        \Auth::user()->unfavo($id);
    }
}
