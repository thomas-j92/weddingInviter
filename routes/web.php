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

// main admin control panel
Route::get('/admin', 'AdminController@index');

// get all people 
Route::get('/people', 'PeopleController@get_all');

// get specific persons details
Route::get('/people/{id}', 'PeopleController@get');