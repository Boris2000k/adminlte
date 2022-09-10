<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('users/permissions','UserController@permissions')->name('users.permissions');

Route::match(['put','path'],'users/permissions{user}','UserController@updatePermissions')->name('users.updatePermissions');

Route::resource('/users','UserController');

Route::resource('/data','DataController');
