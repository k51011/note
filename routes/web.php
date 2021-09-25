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



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home'); 
// Route::get('/notes/create', 'NoteController@create');
Route::get('/', 'NoteController@index')->middleware('auth');
// Route::get('/notes/{note}', 'NoteController@show');
Route::post('/notes', 'NoteController@store');
Route::post('/notes/image', 'NoteController@imageStore');
// Route::put('/notes/update', 'NoteController@update');
// Route::put('/notes/update', 'NoteController@update');
Route::put('/notes/{note}', 'NoteController@update');
Route::get('/categories','CategoryController@index');
Route::delete('/notes/{id}', 'NoteController@destroy');
Route::get('/notes','NoteController@indexnote');
Route::get('/{any}', function() {
    return view('index');
}
)->where('any', '.*');