<?php
require __DIR__.'/sc_routes_league.php';




Route::group(['middleware' => ['auth']], 
            function () {
    Route::get('dashboard', [
        'as' => 'dashboard', 'uses' => 'HomeController@dashboard' ]);


    /***************************************************************************/
    /* Profile
    /***************************************************************************/
    $as_profile = 'profile.';
    Route::get('profile/avatar', [
        'as' => $as_profile.'avatar', 'uses' => 'SC\Comm\ProfileController@avatarPage' ]);
    Route::post('profile/avatar/upload', [
        'as' => $as_profile.'avatar.upload_picture.post', 'uses' => 'SC\Comm\ProfileController@uploadAvatar' ]);

    Route::get('profile/cover-photo', [
        'as' => $as_profile.'cover_photo', 'uses' => 'SC\Comm\ProfileController@coverPhotoPage' ]);
    Route::post('profile/cover-photo/upload', [
        'as' => $as_profile.'cover_photo.upload_picture.post', 'uses' => 'SC\Comm\ProfileController@uploadCoverPhoto' ]);
    Route::post('profile/cover-photo/choose', [
        'as' => $as_profile.'cover_photo.choose_picture.post', 'uses' => 'SC\Comm\ProfileController@chooseCoverPhoto' ]);

    Route::group(['prefix' => 'profile/{user}'], function () {
        $as_profile = 'profile.';
        // User Timeline
        Route::get('/', [
            'as' => $as_profile.'index', 'uses' => 'SC\Comm\ProfileController@profilePage' ]);
        
        // Photos
        Route::get('photos', [
            'as' => $as_profile.'photo', 'uses' => 'SC\Comm\ProfileController@photoPage' ]);
        Route::post('photo/upload', [
            'as' => $as_profile.'photo.upload_picture.post', 'uses' => 'SC\Comm\ProfileController@uploadPhoto' ]);
        Route::post('photo/delete', [
            'as' => $as_profile.'photo.delete_picture.post', 'uses' => 'SC\Comm\ProfileController@deletePhoto' ]);

        // Friends
        Route::get('friends', [
            'as' => $as_profile.'friends', 'uses' => 'SC\Comm\ProfileController@friendsPage' ]);

        Route::post('friends/send-request', [
            'as' => $as_profile.'friends.send_request.post', 'uses' => 'SC\Comm\ProfileController@sendFriendReuqest' ]);
        Route::post('friends/cancel-request', [
            'as' => $as_profile.'friends.cancel_request.post', 'uses' => 'SC\Comm\ProfileController@cancelFriendReuqest' ]);

        Route::post('friends/confirm-request', [
            'as' => $as_profile.'friends.confirm_request.post', 'uses' => 'SC\Comm\ProfileController@confirmFriendReuqest' ]);
        Route::post('friends/reject-request', [
            'as' => $as_profile.'friends.reject_request.post', 'uses' => 'SC\Comm\ProfileController@rejectFriendReuqest' ]);
        Route::post('friends/close-friendship', [
            'as' => $as_profile.'friends.close_friendship.post', 'uses' => 'SC\Comm\ProfileController@closeFriendShip' ]);
        

        // About
        Route::get('about', [
            'as' => $as_profile.'about', 'uses' => 'SC\Comm\ProfileController@aboutContactPage' ]);
        Route::get('about/contact', [
            'as' => $as_profile.'about.contact', 'uses' => 'SC\Comm\ProfileController@aboutContactPage' ]);
        Route::post('about/contact', [
            'as' => $as_profile.'about.save_contact.post', 'uses' => 'SC\Comm\ProfileController@saveContact' ]);
        Route::get('about/basic', [
            'as' => $as_profile.'about.basic', 'uses' => 'SC\Comm\ProfileController@aboutBasicPage' ]);
        Route::post('about/basic', [
            'as' => $as_profile.'about.save_basic.post', 'uses' => 'SC\Comm\ProfileController@saveBasic' ]);

        Route::get('about/education', [
            'as' => $as_profile.'about.education', 'uses' => 'SC\Comm\ProfileController@aboutEducationPage' ]);
        Route::get('about/education/add', [
            'as' => $as_profile.'about.education.add', 'uses' => 'SC\Comm\ProfileController@addEducationPage' ]);
        Route::post('about/education/add', [
            'as' => $as_profile.'about.education.add.post', 'uses' => 'SC\Comm\ProfileController@addEducation' ]);
        Route::get('about/education/{edu}/edit', [
            'as' => $as_profile.'about.education.edit', 'uses' => 'SC\Comm\ProfileController@editEducationPage' ]);
        Route::post('about/education/{edu}/edit', [
            'as' => $as_profile.'about.education.edit.post', 'uses' => 'SC\Comm\ProfileController@editEducation' ]);
        Route::post('about/education/delete', [
            'as' => $as_profile.'about.education.delete.post', 'uses' => 'SC\Comm\ProfileController@deleteEducation' ]);
    });

    /***************************************************************************/
    /* Timeline
    /***************************************************************************/
    Route::post('timeline/{group}/post/add', [
        'as' => 'timeline.post.add.post', 'uses' => 'SC\Comm\TimelineController@addPost' ]);
    Route::post('timeline/post/{post}/comment/add', [
        'as' => 'timeline.post.comment.add.post', 'uses' => 'SC\Comm\TimelineController@addComment' ]);
    Route::post('timeline/post/comment/{comment}/reply', [
        'as' => 'timeline.post.comment.reply.post', 'uses' => 'SC\Comm\TimelineController@replyComment' ]);
    Route::get('timeline/post/{post}/refresh', [
        'as' => 'timeline.post.refresh', 'uses' => 'SC\Comm\TimelineController@refreshPost' ]);

    Route::post('timeline/load-post/{group}/{type}', [
        'as' => 'timeline.load_post', 'uses' => 'SC\Comm\TimelineController@load_next_posts' ]);

    /***************************************************************************/
    /* Search
    /***************************************************************************/
    Route::get('search/people', [
        'as' => 'search.people', 'uses' => 'SC\Comm\SearchController@people' ]);
});

