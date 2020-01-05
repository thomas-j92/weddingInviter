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

// Admin dashboard
// Route::get('/admin/main', 'AdminController@main');

// // Admin guests page
// Route::get('/admin/guests/{type}', 'AdminController@guests');

// // AJAX route to get person
// Route::get('/People/get_ajax/{id}', 'PeopleController@get_ajax');

// // AJAX route to quick update person
// Route::post('/People/quick_edit/', 'PeopleController@quick_edit');

// // Person page
// Route::get('/People/edit/{id}', 'PeopleController@edit');

// // Edit post submit
// Route::post('/People/edit_submit/', 'PeopleController@edit_submit');

// // AJAX route to get HTML code for a specific view
// Route::post('/returnMessageCode', 'ViewController@returnMessageCode');

// Invite creator page
// Route::get('/Invite/create/{id}', 'InviteController@create');

// // View invite page
// Route::get('/Invite/view/{id}', 'InviteController@view');

// // AJAX route to People search
// Route::post('/People/ajax_search/', 'PeopleController@ajax_search');

// // Assign existing guest to invite
// Route::post('/Invite/assignGuestToInvite', 'InviteController@assignToInvite');

// // Assign new guest to invite
// Route::post('/Invite/AssignNewPerson', 'InviteController@assignNewPerson');

// // Remove guest from Invite
// Route::get('/Invite/removeGuest/{invite_id}/{person_id}', 'InviteController@removeGuestFromInvite');

// // Send Invite to People
// Route::get('/Invite/send/{id}', 'InviteController@send');

// Admin Auth
Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

// Get user details
Route::get('user/get/', 'AuthController@get');

// Admin router
Route::get('/admin/{section?}/{filter?}/{filter2?}', 'AdminController@main')->name('home');

Route::get('/invitation/view/{code}', 'InviteController@guestView');


