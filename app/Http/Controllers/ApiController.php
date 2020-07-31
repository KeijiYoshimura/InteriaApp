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

    // public function store(Request $request)
    // {
    //     $result = $request->user()->interiors()->create([
    //         'image' => $request->image,
    //         'category' => $request->category,
    //         'style' => $request->style,
    //         'detail' => $request->detail,
    //         'description' => $request->description,
    //     ]);
    //     return response()->json($result);
    // }

    public function store(Request $request)
    {
        $image_name = $request->image->getClientOriginalName();

        $result = $request->user()->interiors()->create([
            'image' => $request->image->storeAs('public', $image_name),
            'category' => $request->category,
            'style' => $request->style,
            'detail' => $request->detail,
            'description' => $request->description,
        ]);
        return response()->json($result);
    }

    public function update(Request $request, interior $interior)
    {
        $interior->image = $request->image;
        $interior->category = $request->category;
        $interior->style = $request->style;
        $interior->detail = $request->detail;
        $interior->description = $request->description;
        $interior->save();
        return $interior;
    }
}
