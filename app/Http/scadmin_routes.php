<?php

Route::group(['prefix'=>config('sc.webadminRoute'), 
              'middleware' => ['auth', 'permission:WEBADMIN_PANEL']], 
            function () {
    $as = 'scadmin.';

    Route::get('/', [
        'as'=>$as.'dashboard', 'uses'=>'SC\Admin\DashboardController@index' 
    ]);

    // User
    Route::get('users', [
    'as'=>$as.'user.list', 'uses'=>'SC\Admin\UserController@userListPage' 
  ]);
});
