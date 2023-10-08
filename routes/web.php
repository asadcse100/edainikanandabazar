<?php

use Illuminate\Support\Facades\Route;


// Route::auth();

    /*----------------------------------------------------------------------------------------------------------------------------
    | USER LOGIN - REGISTRATION
    |----------------------------------------------------------------------------------------------------------------------------*/
    Route::get('/login','Auth\LoginController@showLoginForm')->name('user.login');
    Route::post('/login','Auth\LoginController@login')->name('login');
    Route::get('/login/forget-password','FrontendController@showUserForgetPasswordForm')->name('user.forget.password');
    Route::get('/login/reset-password/{user}/{token}','FrontendController@showUserResetPasswordForm')->name('user.reset.password');
    Route::post('/login/reset-password','FrontendController@UserResetPassword')->name('user.reset.password.change');
    Route::post('/login/forget-password','FrontendController@sendUserForgetPasswordMail');
    Route::post('/logout','Auth\LoginController@logout')->name('user.logout');
    Route::get('/user-logout','FrontendController@user_logout')->name('frontend.user.logout');
    //user register
    Route::post('/register','Auth\RegisterController@register');
    Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('user.register');
    //user email verify
    Route::get('/user/email-verify','UserDashboardController@user_email_verify_index')->name('user.email.verify');
    Route::get('/user/resend-verify-code','UserDashboardController@reset_user_email_verify_code')->name('user.resend.verify.mail');
    Route::post('/user/email-verify','UserDashboardController@user_email_verify');
    Route::post('/package-user/generate-invoice','FrontendController@generate_package_invoice')->name('frontend.package.invoice.generate');

##LogIn Routes



##Home
Route::get('/', 'EpaperController@index')->name('home');
##SharedItem
Route::get('/uploads/epaper/{year_month}/{month}/{day}/images/shared/{mainImg}/{reatedImg?}', 'EpaperController@SharedItem')->name('Shared');
##ByEdition
Route::get('/{edition}/{date}/{page_no}', 'EpaperController@byEdition')->name('By Edition');
##AllPage
Route::get('/all/pages/{edition}/{date}', 'EpaperController@allPages')->name('All Pages');


// Start Admin from here
Route::group(['middleware' => 'auth'], function() {

	#Logout
	Route::get('/logout', 'Auth\LoginController@logout');


	##########################
	## Dashboard Module
	##########################
	##Dashboard
	Route::get('/home', 'DashboardController@index')->name('Dashboard');
	##RemoveTempFolder
	Route::get('/home/remove-temp-folder/{folder_title}', 'DashboardController@removeTempFolder')->name('Remove Temp Folder');
	##Profile
	Route::get('/profile', 'DashboardController@profile')->name('Profile');
	##ProfileUpdate
	Route::post('/profile/update', 'DashboardController@profileUpdate')->name('Profile Update');
	Route::get('/settings', 'DashboardController@settings')->name('settings');
	Route::post('/settings', 'DashboardController@store')->name('settings.store');

	##########################
	## Category Module
	##########################
	##ManageCategory
	Route::get('/manage-category', 'CategoryController@index')->name('Manage Category');
	##CreateCategory
	Route::post('/category/create', 'CategoryController@create')->name('Create Category');
	##UpdateCategory
	Route::post('/category/update', 'CategoryController@update')->name('Update Category');
	##DeleteCategory
	Route::get('/category/delete/{id}', 'CategoryController@delete')->name('Delete.Category');
	##ChangeStatus
	Route::get('/ajax/category/change-status/{id}/new/{status}', 'CategoryController@changeStatus')->name('Change Status');

	##########################
	## Edition Module
	##########################
	##ManageEdition
	Route::get('/manage-edition', 'EditionController@index')->name('Manage Edition');
	##CreateEdition
	Route::post('/edition/create', 'EditionController@create')->name('Create Edition');
	##UpdateEdition
	Route::post('/edition/update', 'EditionController@update')->name('Update Edition');
	##DeleteEdition
	Route::get('/edition/delete/{id}', 'EditionController@delete')->name('Delete Edition');
	##ChangeStatus
	Route::get('/ajax/edition/change-status/{id}/new/{status}', 'EditionController@changeStatus')->name('Change Status');


	##########################
	## Pages Module
	##########################
	##ManagePages
	Route::get('/manage-pages', 'PageController@index')->name('Manage Pages');
	##PublishPages
	Route::get('/publish-pages', 'PageController@publishPages');
	##publishDate
	Route::get('/publish-pages/{date}', 'PageController@publishDate');
	##UploadPage
	Route::post('/page/create', 'PageController@create')->name('Upload Page');
	##ajaxEditPage
	Route::get('/ajax-edit-page/{publish_date}/new/{page_id}', 'PageController@ajaxEditPage')->name('Edit.Page.Modal');
	##updatePage
	Route::post('/page/update/{page_id}', 'PageController@updatePage')->name('Update Page');
	##DeletePage
	Route::get('/page/delete/{page_id}/new/{page_name}/new/{publish_date}', 'PageController@deletePage')->name('Delete Page');


	##########################
	## Images Module
	##########################
	##MapImage
	Route::get('/{date}/image-mapping-{page_id}', 'ImageController@index')->name('Image Mapping');
	##CropImage
	Route::post('/image-mapping/crop-image/{page_id}', 'ImageController@cropImage')->name('Crop Image');
	
	##AjaxImageRelationModal
	Route::get('/ajax-image-relation/edition/{edition_id}/{image_date}/{related_page}', 'ImageController@AjaxSelectImageRelationModal');

	##AjaxImageRelationUpdateModal
	Route::get('/ajax-image-relation-update/edition/{edition_id}/{image_id}/{related_image}/{image_date}/{related_page}/{relation_type}', 'ImageController@AjaxImageRelationUpdateModal');

	##imageRelationsSave
	Route::post('/manage-relations-save/{image_date}/new/{image_id}', 'ImageController@imageRelationsSave')->name('Image Relations Save');
	##DeleteImage
	Route::get('/image-mapping/delete/{image_id}/new/{image_name}/new/{publish_date}', 'ImageController@deleteImage')->name('Delete Image');



	##########################
	## Advertisement Module
	##########################
	##ManageAdvertisements
	Route::get('/manage-advertisements', 'AdvertisementController@index')->name('Manage Advertisements');
	##UpdateAdvertisements
	Route::post('/advertisement/update', 'AdvertisementController@update')->name('Update Advertisements');



	##########################
	## User Module
	##########################
	##ManageUsers
	Route::get('/manage-users', 'UserController@index')->name('Manage Users');
	##CreateUser
	Route::post('/user/create', 'UserController@create')->name('Create User');
	##UpdateUser
	Route::post('/user/update', 'UserController@update')->name('Update User');

});
