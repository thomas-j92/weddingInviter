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

// Admin Auth
Auth::routes(['register' => false]);

// under maintenance 
Route::get('/', 'WebController@under_construction');

Route::get('/logout', 'Auth\LoginController@logout');

// Get user details
Route::get('user/get/', 'AuthController@get');

// Admin router
Route::get('/admin/{section?}/{filter?}/{filter2?}', 'AdminController@main')->name('home');

// View Invite
Route::get('/invitation/view/{code}', 'InviteController@guestView');

// Save the date - mark as seen
Route::get('/save_the_date/seen/{code}', 'SaveTheDateController@form')->name('std.seen');
Route::post('/save_the_date/verify/{code}', 'SaveTheDateController@verify')->name('std.verify');
