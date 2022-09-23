<?php

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

// Route::get('/', function(){
//     return view('index');
// });


Route::group(['middleware' =>['auth']],function(){
    Route::get('/users', 'UserController@index');
    // Route::post /users　リダイレクト→/users
    Route::get('/', 'WorkController@index');
    Route::get('/works/create', 'WorkController@create');
    Route::get('/works/{work}/edit', 'WorkController@edit');
    Route::put('/works/{work}', 'WorkController@update');
    Route::delete('/works/{work}', 'WorkController@destroy');
    Route::delete('/works/', 'WorkController@tag_destroy');
    Route::get('/works/{work}', 'WorkController@show');
    Route::post('/works' , 'WorkController@store');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
