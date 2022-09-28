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
    Route::post('/users', 'UserController@store');
    Route::get('/works/search', 'WorkController@search')->name('search');
    Route::get('/', 'WorkController@index')->name('index');
    Route::get('/works/create', 'WorkController@create');
    Route::get('/works/{work}', 'WorkController@show')->name('show');
    Route::get('/works/{work}/edit', 'WorkController@edit');
    Route::post('works/{work}/likes', 'FavoriteController@like')->name('likes');
    Route::post('works/{work}/unlikes', 'FavoriteController@unlike')->name('unlikes');
    Route::put('/works/{work}', 'WorkController@update');
    Route::delete('/works/', 'WorkController@tag_destroy')->name('tag_destroy');
    Route::delete('/works/{work}', 'WorkController@destroy');
    Route::post('/works' , 'WorkController@store');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
