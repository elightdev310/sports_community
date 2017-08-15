<?php

Route::group(['middleware' => ['auth']], 
            function () {
    Route::get('dashboard', [
        'as' => 'dashboard', 'uses' => 'HomeController@dashboard' ]);
    Route::get('profile/avatar', [
        'as' => 'profile.avatar', 'uses' => 'SC\Comm\ProfileController@avatarPage' ]);
    Route::post('profile/avatar/upload', [
        'as' => 'profile.avatar.upload_picture.post', 'uses' => 'SC\Comm\ProfileController@uploadAvatar' ]);
    Route::get('profile/cover-photo', [
        'as' => 'profile.cover_photo', 'uses' => 'SC\Comm\ProfileController@coverPhotoPage' ]);
    Route::post('profile/cover-photo/upload', [
        'as' => 'profile.cover_photo.upload_picture.post', 'uses' => 'SC\Comm\ProfileController@uploadCoverPhoto' ]);

    Route::get('profile/{user}', [
        'as' => 'profile.index', 'uses' => 'SC\Comm\ProfileController@profilePage' ]);
    
    Route::get('profile/{user}/photos', [
        'as' => 'profile.photo', 'uses' => 'SC\Comm\ProfileController@photoPage' ]);
    Route::post('profile/{user}/photo/upload', [
        'as' => 'profile.photo.upload_picture.post', 'uses' => 'SC\Comm\ProfileController@uploadPhoto' ]);
    Route::post('profile/{user}/photo/delete', [
        'as' => 'profile.photo.delete_picture.post', 'uses' => 'SC\Comm\ProfileController@deletePhoto' ]);
});

