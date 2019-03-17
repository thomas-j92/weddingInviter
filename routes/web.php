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

Route::get('/admin/main', 'AdminController@main');
Route::get('/admin/guests/{type}', 'AdminController@guests');

// AJAX route to get person
Route::get('/People/get_ajax/{id}', 'PeopleController@get_ajax');

// AJAX route to quick update person
Route::post('/People/quick_edit/', 'PeopleController@quick_edit');

// Person page
Route::get('/People/edit/{id}', 'PeopleController@edit');

// Edit post submit
Route::post('/People/edit_submit/', 'PeopleController@edit_submit');

// AJAX route to get HTML code for a specific view
Route::post('/returnMessageCode', 'ViewController@returnMessageCode');

Auth::routes();

Route::get('/admin', 'AdminController@main')->name('home');
