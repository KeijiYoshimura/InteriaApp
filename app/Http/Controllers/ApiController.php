<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interior;

class ApiController extends Controller
{
    public function index()
    {
        return Interior::orderBy('created_at', 'desc')->get();
    }

    public function mine()
    {
        $user = \Auth::user();
        return $user->interiors()->orderBy('created_at', 'desc')->get();
    }

    public function store(Request $request)
    {
        $result = $request->user()->interiors()->create([
            // 'image' => $request->image,
            'category' => $request->category,
            'style' => $request->style,
            'detail' => $request->detail,
        ]);
        return response()->json($result);
    }
}
