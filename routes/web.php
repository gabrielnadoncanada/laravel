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

// General controller
Auth::routes(['verify' => true]);
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'AdminController@index')->name('admin')->prefix('admin')->middleware('admin');

// image controller

Route::get('/', 'ImageController@index')->name('image');
Route::get('/images/{id}', 'ImageController@view');
Route::get('/image_add', 'ImageController@create')->middleware('auth');
Route::delete('/images/{id}', 'ImageController@delete');
Route::post('/image_add', 'ImageController@store')->middleware('auth');
// Route::get('/images/{location_id}', 'ImageController@bylocation')->name('image.bylocation');
Route::get('/live_search/action', 'ImageController@action')->name('live_search.action');

// location controller
Route::get('/location_add', 'LocationController@create')->middleware('auth');
Route::post('/location_add', 'LocationController@store')->middleware('auth');
Route::get('/image_add', 'LocationController@index')->name('location');

Route::post('/report/{id}', 'ImageController@report')->middleware('auth');

Route::get('/images/{id}/edit', 'ImageController@edit')->middleware('auth')->name('image.edit');








