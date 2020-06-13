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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function () {

    Route::resource('/posts', 'PostController')->except('index');

    Route::post('/posts/{post}/comments', 'CommentController@store')->name('comment.store');

    Route::put('/posts/{post}/comments/{comment}', 'CommentController@update')->name('comment.update');

    Route::delete('/posts/{post}/comments/{comment}', 'CommentController@destroy')->name('comment.delete');
});

Route::get('/posts', 'PostController@index');



