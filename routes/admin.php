<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth'], function() {

	#Logout
	Route::get('/logout', 'Auth\AuthController@logout');


	// ##########################
	// ## Dashboard Module
	// ##########################
	// ##Dashboard
	// Route::get('/home', 'DashboardController@index')->name('Dashboard');
	// ##RemoveTempFolder
	// Route::get('/home/remove-temp-folder/{folder_title}', 'DashboardController@removeTempFolder')->name('Remove Temp Folder');
	// ##Profile
	// Route::get('/profile', 'DashboardController@profile')->name('Profile');
	// ##ProfileUpdate
	// Route::post('/profile/update', 'DashboardController@profileUpdate')->name('Profile Update');


	// ##########################
	// ## Category Module
	// ##########################
	// ##ManageCategory
	// Route::get('/manage-category', 'CategoryController@index')->name('Manage Category');
	// ##CreateCategory
	// Route::post('/category/create', 'CategoryController@create')->name('Create Category');
	// ##UpdateCategory
	// Route::post('/category/update', 'CategoryController@update')->name('Update Category');
	// ##DeleteCategory
	// Route::get('/category/delete/{id}', 'CategoryController@delete')->name('Delete Category');
	// ##ChangeStatus
	// Route::get('/ajax/category/change-status/{id}/{status}', 'CategoryController@changeStatus')->name('Change Status');

	// ##########################
	// ## Edition Module
	// ##########################
	// ##ManageEdition
	// Route::get('/manage-edition', 'EditionController@index')->name('Manage Edition');
	// ##CreateEdition
	// Route::post('/edition/create', 'EditionController@create')->name('Create Edition');
	// ##UpdateEdition
	// Route::post('/edition/update', 'EditionController@update')->name('Update Edition');
	// ##DeleteEdition
	// Route::get('/edition/delete/{id}', 'EditionController@delete')->name('Delete Edition');
	// ##ChangeStatus
	// Route::get('/ajax/edition/change-status/{id}/{status}', 'EditionController@changeStatus')->name('Change Status');


	// ##########################
	// ## Pages Module
	// ##########################
	// ##ManagePages
	// Route::get('/manage-pages', 'PageController@index')->name('Manage Pages');
	// ##PublishPages
	// Route::get('/publish-pages', 'PageController@publishPages');
	// ##publishDate
	// Route::get('/publish-pages/{date}', 'PageController@publishDate');
	// ##UploadPage
	// Route::post('/page/create', 'PageController@create')->name('Upload Page');
	// ##ajaxEditPage
	// Route::get('/ajax-edit-page/{publish_date}/{page_id}', 'PageController@ajaxEditPage')->name('Edit Page Modal');
	// ##updatePage
	// Route::post('/page/update/{page_id}', 'PageController@updatePage')->name('Update Page');
	// ##DeletePage
	// Route::get('/page/delete/{page_id}/{page_name}/{publish_date}', 'PageController@deletePage')->name('Delete Page');


	// ##########################
	// ## Images Module
	// ##########################
	// ##MapImage
	// Route::get('/{date}/image-mapping-{page_id}', 'ImageController@index')->name('Image Mapping');
	// ##CropImage
	// Route::post('/image-mapping/crop-image/{page_id}', 'ImageController@cropImage')->name('Crop Image');
	
	// ##AjaxImageRelationModal
	// Route::get('/ajax-image-relation/edition/{edition_id}/{image_date}/{related_page}', 'ImageController@AjaxSelectImageRelationModal');

	// ##AjaxImageRelationUpdateModal
	// Route::get('/ajax-image-relation-update/edition/{edition_id}/{image_id}/{related_image}/{image_date}/{related_page}/{relation_type}', 'ImageController@AjaxImageRelationUpdateModal');

	// ##imageRelationsSave
	// Route::post('/manage-relations-save/{image_date}/{image_id}', 'ImageController@imageRelationsSave')->name('Image Relations Save');
	// ##DeleteImage
	// Route::get('/image-mapping/delete/{image_id}/{image_name}/{publish_date}', 'ImageController@deleteImage')->name('Delete Image');



	// ##########################
	// ## Advertisement Module
	// ##########################
	// ##ManageAdvertisements
	// Route::get('/manage-advertisements', 'AdvertisementController@index')->name('Manage Advertisements');
	// ##UpdateAdvertisements
	// Route::post('/advertisement/update', 'AdvertisementController@update')->name('Update Advertisements');



	// ##########################
	// ## User Module
	// ##########################
	// ##ManageUsers
	// Route::get('/manage-users', 'UserController@index')->name('Manage Users');
	// ##CreateUser
	// Route::post('/user/create', 'UserController@create')->name('Create User');
	// ##UpdateUser
	// Route::post('/user/update', 'UserController@update')->name('Update User');

});
