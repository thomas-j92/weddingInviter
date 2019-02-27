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
// Route::get('/admin/{name}', 'AdminController@{$name}');

// Route::get('foo', 'AdminController@method');

// Route::resource('admin', 'AdminController');

// get all people 
// Route::get('/people', 'PeopleController@get_all');

// get specific persons details
// Route::get('/people/{id}', 'PeopleController@get');

Route::get('/admin', 'AdminController@index');
Route::get('/admin/guests/{type}', 'AdminController@guests');

// AJAX route to get person
Route::get('/People/get_ajax/{id}', 'PeopleController@get_ajax');

// AJAX route to quick update person
Route::post('/People/quick_edit/', 'PeopleController@quick_edit');

// AJAX route to get HTML code for a specific view
Route::post('/returnMessageCode', 'ViewController@returnMessageCode');
