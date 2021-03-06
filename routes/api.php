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
Route::post('people/avatar/', 'Api\PeopleController@updateAvatar');
Route::apiResource('people', 'Api\PeopleController', ['as' => 'api']);

// CsvUpload
Route::get('csv_upload/getAll/', 'Api\CsvUploadController@getAll');
Route::apiResource('csv_upload', 'Api\CsvUploadController', ['as' => 'api']);

// Invite
Route::get('invite/getAll', 'Api\InviteController@getAll');
Route::get('invite/send/{id}', 'Api\InviteController@send');
Route::get('invite/getEmails/{id}', 'Api\InviteController@getEmails');
Route::post('invite/web/', 'Api\InviteController@webCreate');
Route::put('invite/addAdditionalGuests/', 'Api\InviteController@addAdditionalGuests');
Route::delete('invite/deleteAdditionalGuest/{id}', 'Api\InviteController@deleteAdditionalGuest');
Route::post('invite/addPlusOne/', 'Api\InviteController@addPlusOne');
Route::delete('invite/deletePlusOne/{id}', 'Api\InviteController@deletePlusOne');
Route::put('invite/updateRsvp', 'Api\InviteController@updateRsvp');
Route::get('invite/activity/{id}', 'Api\InviteController@getActivity');
Route::get('invite/getByCode/{code}', 'Api\InviteController@getByCode');
Route::post('invite/rsvp/{id}', 'Api\InviteController@webRsvp');
Route::apiResource('invite', 'Api\InviteController', ['as' => 'api']);

// SaveTheDate
Route::get('save_the_date/getAll/', 'Api\SaveTheDateController@getAll');
Route::get('save_the_date/getBulkRequests/', 'Api\SaveTheDateController@getBulkRequests');
Route::get('save_the_date/getBulkSend/{id}', 'Api\SaveTheDateController@getBulkSend');
Route::post('save_the_date/saveBulkSend/', 'Api\SaveTheDateController@saveBulkSend');
Route::get('save_the_date/bulkElementSent/{id}', 'Api\SaveTheDateController@bulkElementSent');

Route::post('save_the_date/generate/{id}', 'Api\SaveTheDateController@generate');
Route::get('save_the_date/send/{id}', 'Api\SaveTheDateController@send');

Route::apiResource('save_the_date', 'Api\SaveTheDateController', ['as' => 'api']);

// Email
Route::get('email/getAll/', 'Api\EmailController@getAll');
Route::apiResource('email', 'Api\EmailController', ['as' => 'api']);