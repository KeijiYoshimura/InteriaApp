<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interior;
use App\User;

class ApiController extends Controller
{
    public function index()
    {
        return Interior::orderBy('created_at', 'desc')->get();
    }

    public function users()
    {
        return User::all();
    }

    public function mine()
    {
        $user = \Auth::user();
        return $user->interiors()->orderBy('created_at', 'desc')->get();
    }

    public function each(User $user)
    {
        //$user = \Auth::user();
        return $user->interiors()->orderBy('created_at', 'desc')->get();
    }

    public function user(User $user)
    {
        // $interior = Interior::find($id);
        return $user;
    }

    public function store(Request $request)
    {
        //$image_name = $request->image->getClientOriginalName();
        $result = $request->user()->interiors()->create([
            'image' => $request->image->store('public'),
            'tag' => $request->tag,
            'style' => $request->style,
            'category' => $request->category,
            'detail' => $request->detail,
            'description' => $request->description,
        ]);
        return response()->json($result);
    }

    public function update(Request $request, Interior $interior)
    {
        $interior->image = $request->image->store('public');
        $interior->tag = $request->tag;
        $interior->description = $request->description;
        $interior->save();
        return $interior;
    }

    public function destroy(Request $request, Interior $interior)
    {
        $result = 'ok';
        if (!$interior->delete()) {
            $result = 'ng';
        }
        return compact('result');
    }
}
