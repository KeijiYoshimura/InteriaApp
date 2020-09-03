<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interior;
use App\User;
use App\Http\Controllers\Storage;
use Illuminate\Support\Facades\Auth;
use Encore\Admin\Facades\Admin;

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
        $user = Auth::user();
        return $user->interiors()->orderBy('created_at', 'desc')->get();
    }

    public function each(User $user)
    {
        return $user->interiors()->orderBy('created_at', 'desc')->get();
    }

    public function user(User $user)
    {
        return $user;
    }

    public function auth()
    {
        $user = Auth::user();
        return $user;
    }

    public function store(Request $request)
    {
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

    public function create(Request $request)
    {
        $disk = \Storage::disk('s3');
        $fileName = $disk->put('', $request->image);
        $result = $request->user()->interiors()->create([
            'image' => $disk->url($fileName),
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
