<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/top', 'InteriorsController@top');
    Route::get('/new', 'InteriorsController@new');
    Route::get('/mine', 'InteriorsController@mine');
    Route::get('/detail/{id}', 'InteriorsController@detail');
    Route::get('/edit/{interior}', 'InteriorsController@edit');
    Route::get('/chat1', 'InteriorsController@chat');

    Route::get('/users', 'UsersController@users');
    Route::get('/followInteriors', 'UsersController@followInteriors');
    Route::get('/show/{id}', 'UsersController@show');
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('follow', 'UserFollowController@store')->name('user.follow');
        Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
        Route::get('checkFollow', 'UsersController@checkFollow')->name('users.checkFollow');
        Route::get('followings', 'UsersController@followings')->name('users.followings');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
        Route::get('counts', 'Controller@counts');
    });

    Route::get('/favoriteInteriors', 'UsersController@favoriteInteriors');
    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('favo', 'UserFavoriteController@store')->name('user.favorite');
        Route::delete('unfavo', 'UserFavoriteController@destroy')->name('user.unfavorite');
        Route::get('checkFavo', 'UsersController@checkFavo')->name('users.checkFavo');
        Route::get('favorites', 'UsersController@followings')->name('users.favorites');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });

    Route::group(['prefix' => 'users/{id}'], function () {
        Route::post('watch', 'UserWatchController@store')->name('user.watch');
        Route::delete('unwatch', 'UserWatchController@destroy')->name('user.unwatch');
        Route::get('checkWatch', 'UsersController@checkWatch')->name('users.checkWatch');
        Route::get('watchMessages', 'UsersController@watchMessages');
        Route::get('favorites', 'UsersController@followings')->name('users.favorites');
        Route::get('followers', 'UsersController@followers')->name('users.followers');
    });

    Route::get('counts/{interior}', 'Controller@countsFavo');
});

Route::prefix('api')->group(function () {
    Route::get('/interiors', 'ApiController@index');
    Route::get('/interiors/{user}', 'ApiController@mine');
    Route::get('/interiors/mine', 'ApiController@mine');
    // Route::post('/interiors', 'ApiController@store');
    Route::post('/interiors', 'ApiController@create');
    Route::post('/interiors/{interior}', 'ApiController@update');
    Route::delete('/interiors/{interior}', 'ApiController@destroy');

    Route::get('/users', 'ApiController@users');
    Route::get('/users/auth', 'ApiController@auth');
    Route::get('/users/{user}', 'ApiController@user');
});

Auth::routes();

Route::get('chat', 'ChatController@index');
Route::get('ajax/chat/{interior}', 'Ajax\ChatController@index');
Route::post('ajax/chat', 'Ajax\ChatController@create');
Route::delete('ajax/chat/{message}', 'Ajax\ChatController@destroy');
Route::post('ajax/chat/{message}', 'Ajax\ChatController@update');
Route::patch('ajax/chat/{message}/read', 'Ajax\ChatController@changeRead');
