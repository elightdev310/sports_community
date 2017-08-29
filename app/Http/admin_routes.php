<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';
	
	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {
	
	/* ================== Dashboard ================== */
	
	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');
	
	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	
	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');
	
	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');
	
	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');
	
	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');
	
	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	
	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

	/* ================== SocialProfiles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/socialprofiles', 'LA\SocialProfilesController');
	Route::get(config('laraadmin.adminRoute') . '/socialprofile_dt_ajax', 'LA\SocialProfilesController@dtajax');

	/* ================== UserActivationCodes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/useractivationcodes', 'LA\UserActivationCodesController');
	Route::get(config('laraadmin.adminRoute') . '/useractivationcode_dt_ajax', 'LA\UserActivationCodesController@dtajax');

	/* ================== UserProfiles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/userprofiles', 'LA\UserProfilesController');
	Route::get(config('laraadmin.adminRoute') . '/userprofile_dt_ajax', 'LA\UserProfilesController@dtajax');

	/* ================== Teams ================== */
	Route::resource(config('laraadmin.adminRoute') . '/teams', 'LA\TeamsController');
	Route::get(config('laraadmin.adminRoute') . '/team_dt_ajax', 'LA\TeamsController@dtajax');

	/* ================== Leagues ================== */
	Route::resource(config('laraadmin.adminRoute') . '/leagues', 'LA\LeaguesController');
	Route::get(config('laraadmin.adminRoute') . '/league_dt_ajax', 'LA\LeaguesController@dtajax');


	/* ================== Photos ================== */
	Route::resource(config('laraadmin.adminRoute') . '/photos', 'LA\PhotosController');
	Route::get(config('laraadmin.adminRoute') . '/photo_dt_ajax', 'LA\PhotosController@dtajax');

	/* ================== Nodes ================== */
	Route::resource(config('laraadmin.adminRoute') . '/nodes', 'LA\NodesController');
	Route::get(config('laraadmin.adminRoute') . '/node_dt_ajax', 'LA\NodesController@dtajax');

	/* ================== Posts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/posts', 'LA\PostsController');
	Route::get(config('laraadmin.adminRoute') . '/post_dt_ajax', 'LA\PostsController@dtajax');

	/* ================== PostComments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/postcomments', 'LA\PostCommentsController');
	Route::get(config('laraadmin.adminRoute') . '/postcomment_dt_ajax', 'LA\PostCommentsController@dtajax');

	/* ================== Education ================== */
	Route::resource(config('laraadmin.adminRoute') . '/education', 'LA\EducationController');
	Route::get(config('laraadmin.adminRoute') . '/education_dt_ajax', 'LA\EducationController@dtajax');

	/* ================== FriendRequests ================== */
	Route::resource(config('laraadmin.adminRoute') . '/friendrequests', 'LA\FriendRequestsController');
	Route::get(config('laraadmin.adminRoute') . '/friendrequest_dt_ajax', 'LA\FriendRequestsController@dtajax');
});
