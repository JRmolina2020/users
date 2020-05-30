<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('login', 'AuthController@login');
Route::group(['middleware' => 'auth'], function () {
    Route::get('usuarios', function () {
        return view('users.index');
    });
    Route::resource('users', 'UserController')->except([
        'show', 'create', 'edit'
    ]);
    Route::get('users/checkemail', 'UserController@checkemail');
    Route::put('users/available/{id}', 'UserController@available');
    Route::put('users/locked/{id}', 'UserController@locked');
    Route::put('users/password/{id}', 'UserController@updatepassword');
    Route::post('logout', 'AuthController@logout')->name('logout');
});