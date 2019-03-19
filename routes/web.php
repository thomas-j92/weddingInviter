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
Route::get('/admin/main', 'AdminController@main');

// Admin guests page
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

// Admin login
Auth::routes();
Route::get('/admin', 'AdminController@main')->name('home');

// Invite creator page
Route::get('/Invite/create/{id}', 'InviteController@create');
