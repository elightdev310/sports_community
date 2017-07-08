<?php

Route::group(['middleware' => ['auth']], 
            function () {
    Route::get('dashboard', [
        'as' => 'dashboard', 'uses' => 'HomeController@dashboard' ]);
});
