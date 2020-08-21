<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('interior/chat');
    }

    public function template()
    {
        return view('interior/template');
    }
}
