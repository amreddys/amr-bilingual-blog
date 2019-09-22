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

Route::get('/', 'HomeController@main');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('setlocale/{locale}','HomeController@setLocale');

Route::get('/post/{slug_str}',"PostController@view")->name('post_view');
Route::get('/posts_list','PostController@list');
Route::get('/posts/edit/{post}','PostController@edit');
Route::resource('/posts','PostController');

Route::get('/categories/list','CategoryController@list');
Route::resource('/categories','CategoryController');

Route::post('/media/image_upload', 'MediaController@upload');
