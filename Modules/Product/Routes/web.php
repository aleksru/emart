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
    //'namespace' => 'Modules\Product\Http\Controllers',
    'as' => 'admin.'
], function() {
    Route::resource('product', 'ProductController')->except(['show']);
    Route::get('product/datatable', 'ProductController@datatable')->name('product.datatable');
    Route::post('toggle-product/{product}', 'ProductController@toggleActive')->name('product.toggle_is_active');
});
