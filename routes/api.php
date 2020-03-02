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
Route::apiResource('people', 'Api\PeopleController', ['as' => 'api']);

// Invite
Route::get('invite/send/{id}', 'Api\InviteController@send');
Route::get('invite/getEmails/{id}', 'Api\InviteController@getEmails');
Route::post('invite/web/', 'Api\InviteController@webCreate');
Route::put('invite/addAdditionalGuests/', 'Api\InviteController@addAdditionalGuests');
Route::delete('invite/deleteAdditionalGuest/{id}', 'Api\InviteController@deleteAdditionalGuest');
Route::post('invite/addPlusOne/', 'Api\InviteController@addPlusOne');
Route::apiResource('invite', 'Api\InviteController', ['as' => 'api']);

// Email
Route::get('email/getAll/', 'Api\EmailController@getAll');
Route::apiResource('email', 'Api\EmailController', ['as' => 'api']);