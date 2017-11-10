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

//Route::get('/', function () {
//    return view('home');
//});
Route::get  ('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get  ('/home', 'HomeController@index')->name('home');
Route::patch('/home', 'HomeController@postIndex' );

Route::get  ('/track', 'TrackController@index')->name('track');
Route::post ('/track', 'TrackController@post')->name('track');

Route::get  ('/reflect', 'HomeController@reflect')->name('reflect');

Route::put('/profile', [ 'as' => 'profile.update', 'uses' => 'ProfileController@updateProfile'] );
Route::get('/profile', 'ProfileController@index');

Route::get('/test', 'FieldController@testStore');

Route::get('/ajax-get-userfield-habits', 'UserFieldsController@ajaxGetFieldHabits');

Route::get('/ajax-tracker-get-userfield-habits', 'UserFieldsController@ajaxTrackerGetFieldHabits');
Route::get('/ajax-reflector-get-userfield-habits', 'UserFieldsController@ajaxReflectorGetFieldHabits');
Route::get('/ajax-tracker-get-userfield-habit-unit', 'UserFieldsController@ajaxTrackerGetFieldHabitUnit');
Route::get('/ajax-tracker-get-userfield-habit-tags', 'UserFieldsController@ajaxTrackerGetFieldHabitTags');

Route::post('/fieldhabit', 'FHabitController@store');    // Habit add
Route::get('/fieldhabit', 'FHabitController@edit');

//Route::get('/ajax-get-userfield-habits', [ 'as' => 'ajax-get-userfield-habits', 'uses' => 'UserFieldsController@ajaxGetFieldHabits'] );
//Route::get('/ajax', 'UserFieldsController@ajaxGetFieldHabits' )->name('ajax');
//Route::get('/ajax', 'UserFieldsController@index' )->name('ajax');
Route::get('/test', 'testController@index');

// New approach!
Route::resource('field', 'FieldController');
Route::resource('userfield', 'UserFieldsController');
Route::resource('logs', 'DotilogController');

Route::patch('/home', 'HomeController@postIndex' );