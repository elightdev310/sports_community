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

    Route::get('profile/{user}/about', [
        'as' => 'profile.about', 'uses' => 'SC\Comm\ProfileController@aboutContactPage' ]);

    Route::get('profile/{user}/about/contact', [
        'as' => 'profile.about.contact', 'uses' => 'SC\Comm\ProfileController@aboutContactPage' ]);
    Route::post('profile/{user}/about/contact', [
        'as' => 'profile.about.save_contact.post', 'uses' => 'SC\Comm\ProfileController@saveContact' ]);
    Route::get('profile/{user}/about/basic', [
        'as' => 'profile.about.basic', 'uses' => 'SC\Comm\ProfileController@aboutBasicPage' ]);
    Route::post('profile/{user}/about/basic', [
        'as' => 'profile.about.save_basic.post', 'uses' => 'SC\Comm\ProfileController@saveBasic' ]);

    Route::get('profile/{user}/about/education', [
        'as' => 'profile.about.education', 'uses' => 'SC\Comm\ProfileController@aboutEducationPage' ]);
    Route::get('profile/{user}/about/education/add', [
        'as' => 'profile.about.education.add', 'uses' => 'SC\Comm\ProfileController@addEducationPage' ]);
    Route::post('profile/{user}/about/education/add', [
        'as' => 'profile.about.education.add.post', 'uses' => 'SC\Comm\ProfileController@addEducation' ]);
    Route::get('profile/{user}/about/education/{edu}/edit', [
        'as' => 'profile.about.education.edit', 'uses' => 'SC\Comm\ProfileController@editEducationPage' ]);
    Route::post('profile/{user}/about/education/{edu}/edit', [
        'as' => 'profile.about.education.edit.post', 'uses' => 'SC\Comm\ProfileController@editEducation' ]);
    Route::post('profile/{user}/about/education/delete', [
        'as' => 'profile.about.education.delete.post', 'uses' => 'SC\Comm\ProfileController@deleteEducation' ]);

    Route::post('timeline/{group}/post/add', [
        'as' => 'timeline.post.add.post', 'uses' => 'SC\Comm\TimelineController@addPost' ]);

    Route::post('timeline/post/{post}/comment/add', [
        'as' => 'timeline.post.comment.add.post', 'uses' => 'SC\Comm\TimelineController@addComment' ]);

    Route::post('timeline/post/comment/{comment}/reply', [
        'as' => 'timeline.post.comment.reply.post', 'uses' => 'SC\Comm\TimelineController@replyComment' ]);

    Route::get('timeline/post/{post}/refresh', [
        'as' => 'timeline.post.refresh', 'uses' => 'SC\Comm\TimelineController@refreshPost' ]);
});

