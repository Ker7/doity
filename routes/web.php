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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get  ('/home', 'HomeController@index')->name('home');
Route::patch('/home', 'HomeController@postIndex' );

Route::put('/profile', [ 'as' => 'profile.update', 'uses' => 'ProfileController@updateProfile'] );
Route::get('/profile', 'ProfileController@index');

Route::get('/test', 'FieldController@testStore');

// New approach!
Route::resource('field', 'FieldController');
Route::resource('userfield', 'UserFieldsController');
Route::resource('logs', 'DotilogController');

Route::patch('/home', 'HomeController@postIndex' );