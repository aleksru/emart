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

Route::group([
    //'middleware' => ['web', 'auth', 'role:admin'],
    'prefix' => 'admin',
    //'namespace' => 'Modules\Category\Http\Controllers',
    'as' => 'admin.'
], function() {
    Route::get('/', 'AdminController@index')->name('index');
});
