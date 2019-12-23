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

//Route::prefix('category')->group(function() {
//    Route::get('/', 'CategoryController@index');
//});
Route::group([
    //'middleware' => ['web', 'auth', 'role:admin'],
    'prefix' => 'admin',
    //'namespace' => 'Modules\Category\Http\Controllers',
    'as' => 'admin.'
], function() {
    Route::resource('category', 'CategoryController')->except(['show']);
    Route::get('category/datatable', 'CategoryController@datatable')->name('category.datatable');
    Route::post('toggle-is-active/{category}', 'CategoryController@toggleActive')->name('category.toggle_is_active');
    Route::post('toggle-deleted-at', 'CategoryController@toggleDeletedAt')->name('category.toggle_deleted_at');
});