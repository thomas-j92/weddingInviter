<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// People
Route::get('people/showAll/{filter?}', 'Api\PeopleController@showAll');
Route::get('people/get_all/', 'Api\PeopleController@get_all');
Route::put('people/deletePerson/{id}', 'Api\PeopleController@deletePerson');
Route::post('people/upload/', 'Api\PeopleController@upload');
Route::apiResource('people', 'Api\PeopleController', ['as' => 'api']);

// CsvUpload
Route::get('csv_upload/getAll/', 'Api\CsvUploadController@getAll');
Route::apiResource('csv_upload', 'Api\CsvUploadController', ['as' => 'api']);

// Invite
Route::get('invite/send/{id}', 'Api\InviteController@send');
Route::get('invite/getEmails/{id}', 'Api\InviteController@getEmails');
Route::post('invite/web/', 'Api\InviteController@webCreate');
Route::put('invite/addAdditionalGuests/', 'Api\InviteController@addAdditionalGuests');
Route::delete('invite/deleteAdditionalGuest/{id}', 'Api\InviteController@deleteAdditionalGuest');
Route::post('invite/addPlusOne/', 'Api\InviteController@addPlusOne');
Route::delete('invite/deletePlusOne/{id}', 'Api\InviteController@deletePlusOne');
Route::put('invite/updateRsvp', 'Api\InviteController@updateRsvp');
Route::get('invite/activity/{id}', 'Api\InviteController@getActivity');
Route::apiResource('invite', 'Api\InviteController', ['as' => 'api']);

// Email
Route::get('email/getAll/', 'Api\EmailController@getAll');
Route::apiResource('email', 'Api\EmailController', ['as' => 'api']);