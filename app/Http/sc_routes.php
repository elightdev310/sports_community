<?php

Route::group(['middleware' => ['auth']], 
            function () {
    Route::get('dashboard', [
        'as' => 'dashboard', 'uses' => 'HomeController@dashboard' ]);
    Route::get('profile', [
        'as' => 'profile.index', 'uses' => 'SC\Comm\ProfileController@profilePage' ]);
    Route::get('profile/avatar', [
        'as' => 'profile.avatar', 'uses' => 'SC\Comm\ProfileController@avatarPage' ]);
    Route::post('profile/avatar/save', [
        'as' => 'profile.avatar.save_picture.post', 'uses' => 'SC\Comm\ProfileController@saveAvatar' ]);
});

