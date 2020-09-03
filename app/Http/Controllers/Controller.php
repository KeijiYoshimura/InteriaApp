<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\User;
use App\Interior;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function counts($id)
    {
        $user = User::find($id);
        $count_interiors = $user->interiors()->count();
        $count_followings = $user->followings()->count();
        $count_followers = $user->followers()->count();

        return [
            'count_interiors' => $count_interiors,
            'count_followings' => $count_followings,
            'count_followers' => $count_followers,
        ];
    }

    public function countsFavo(Interior $interior)
    {
        $count_favorites = $interior->isfavorites()->count();
        return $count_favorites;
    }
}
