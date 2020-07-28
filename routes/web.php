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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'InteriorsController@top');
    Route::get('/new', 'InteriorsController@new');
    Route::get('/private', 'InteriorsController@private');
    Route::get('/work', 'InteriorsController@work');
});

Route::prefix('api')->group(function () {
    Route::get('/interiors', 'ApiController@index');
    Route::post('/interiors', 'ApiController@store');
    Route::delete('/interiors/{interior}', 'ApiController@destroy');
    Route::patch('/interiors/{interior}/fin', 'ApiController@changeFinish');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
