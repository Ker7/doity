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

//dd(App::environment());

Route::get  ('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get  ('/home', 'HomeController@index')->name('home');
Route::patch('/home', 'HomeController@postIndex' );

Route::get  ('/track', 'TrackController@index')->name('track');
Route::post ('/track', 'TrackController@post')->name('track');

Route::get  ('/reflect', 'HomeController@reflect')->name('reflect');
//Route::get  ('/reflect/{csv}', 'HomeController@reflect')->name('reflect');

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
Route::resource('bankdays', 'BankdaysController');

Route::resource('field', 'FieldController');
Route::resource('userfield', 'UserFieldsController');
Route::put('logs/start', 'DotilogsController@start' )->name('logs.start');
Route::put('logs/store/{id}', 'DotilogsController@store' )->name('logs.store');
Route::put('logs/forward', 'DotilogsController@forward' )->name('logs.forward');
Route::patch('logs/destroy/{id}', 'DotilogsController@destroy' )->name('remlog');
Route::patch('logs/finish/{id}', 'DotilogsController@finish' )->name('logs.finish');

Route::resource('logs', 'DotilogsController');
//Route::resource('logs', 'DotilogsController', ['parameters' => [
//    'index' => 'filter'
//]]);


//OLD sync methro tobe removed
//Route::patch('sync', 'HomeController@sync' )->name('sync'); // Syncronizing new users
//Route::get('sync', 'HomeController@sync' )->name('sync'); // Syncronizing new users

Route::get('calendar', 'HomeController@calendar' )->name('calendar'); // Syncronizing new users

Route::patch('/home', 'HomeController@postIndex' );