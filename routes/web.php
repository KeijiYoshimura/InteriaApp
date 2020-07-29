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
    Route::get('/detail/{interior}', 'InteriorsController@detail');
    Route::get('/edit/{interior}', 'InteriorsController@edit');
});

Route::prefix('api')->group(function () {
    Route::get('/interiors', 'ApiController@index');
    // Route::get('/interiors/{interior}', 'ApiController@show');
    Route::get('/interiors/mine', 'ApiController@mine');
    Route::post('/interiors', 'ApiController@store');
    Route::put('/interiors/{interior}', 'ApiController@update');
    Route::delete('/interiors/{interior}', 'ApiController@destroy');
    Route::patch('/interiors/{interior}/fin', 'ApiController@changeFinish');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
