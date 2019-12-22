<?php

Route::group([
    'middleware' => ['web'],//, 'auth', 'role:admin'],
    'prefix' => 'admin/media',
    'namespace' => 'Modules\Media\Http\Controllers\Admin',
    'as' => 'admin.media.'], function() {
    
    Route::group(['prefix' => 'images', 'as' => 'images.'], function () {
        Route::post('delete', 'ImagesController@delete')->name('delete');
        Route::post('upload', 'ImagesController@upload')->name('upload');
        Route::post('replace', 'ImagesController@replace')->name('replace');
    });
    
});
