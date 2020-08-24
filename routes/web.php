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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'InteriorsController@top');
    Route::get('/new', 'InteriorsController@new');
    Route::get('/mine', 'InteriorsController@mine');
    Route::get('/detail/{id}', 'InteriorsController@detail');
    Route::get('/edit/{interior}', 'InteriorsController@edit');
    Route::get('/chat1', 'InteriorsController@chat');
    Route::get('/template', 'InteriorsController@template');


    Route::get('/index', 'UsersController@index');
    Route::get('/show/{id}', 'UsersController@show');

    // Route::group(['prefix' => 'users/{id}'], function () {
    //     Route::post('follow', 'UserFollowController@store')->name('user.follow');
    //     Route::delete('unfollow', 'UserFollowController@destroy')->name('user.unfollow');
    //     Route::get('followings', 'UsersController@followings')->name('users.followings');
    //     Route::get('followers', 'UsersController@followers')->name('users.followers');
    // });
});

Route::prefix('api')->group(function () {
    Route::get('/interiors', 'ApiController@index');
    //Route::get('/interiors/{interior}', 'ApiController@show');
    Route::get('/interiors/mine', 'ApiController@mine');
    Route::get('/interiors/{user}', 'ApiController@mine');
    Route::post('/interiors', 'ApiController@store');

    // Route::post('/interiors', function () {
    //     $image_name = request()->image->getClientOriginalName();
    //     request()->image->storeAs('public/', $image_name);
    // });

    // Route::post('interiors', function () {
    //     dd(request()->all());
    // });
    Route::post('/interiors/{interior}', 'ApiController@update');
    Route::delete('/interiors/{interior}', 'ApiController@destroy');
    //Route::patch('/interiors/{interior}/fin', 'ApiController@changeFinish');

    Route::get('/users', 'ApiController@users');
    Route::get('/users/{user}', 'ApiController@user');
});

Auth::routes();

Route::get('chat', 'ChatController@index');
Route::get('ajax/chat/{interior}', 'Ajax\ChatController@index');
Route::post('ajax/chat', 'Ajax\ChatController@create');
Route::delete('ajax/chat/{message}', 'Ajax\ChatController@destroy');
//Route::delete('ajax/chat', 'Ajax\ChatController@destroy');
Route::post('ajax/chat/{message}', 'Ajax\ChatController@update');


Route::get('template', 'ChatController@template');
