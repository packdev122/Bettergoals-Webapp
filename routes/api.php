<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::group([
    'middleware' => 'auth:api',
], function () {
	// Category
    Route::get('/categories', 'API\CategoryController@all');
    Route::post('/category', 'API\CategoryController@store');
    Route::delete('/category/{id}', 'API\CategoryController@destroy');
    Route::put('/category/{id}', 'API\CategoryController@update');

    // People
    Route::get('/contacts', 'API\AppointmentController@allContacts');
    Route::post('/new/contact', 'API\AppointmentController@createContact');
    Route::post('/new/reminder', 'API\AppointmentController@createReminder');
    Route::post('/new/organisation', 'API\AppointmentController@createOrganisation');
  

    // Org Contact
    Route::get('/organisations', 'API\AppointmentController@allOrganisations');
    Route::get('/organisation/{id}', 'API\AppointmentController@address');

    // Activities

    Route::post('activities/load-more', 'ActivityController@loadMore');


    Route::get('/appointments/{start}/{end}', 'API\AppointmentController@all');
    Route::get('/tasks/{start}/{end}', 'API\AppointmentController@allTask');
    Route::post('/appointment', 'API\AppointmentController@store');
    Route::delete('/appointment/{id}', 'API\AppointmentController@destroy');
    Route::put('/appointment/{id}', 'API\AppointmentController@update');
    Route::post('/appointment/update', 'API\AppointmentController@eventUpdate');
    Route::post('/task/update', 'API\AppointmentController@eventTaskUpdate');

    // Add PWD Member
    Route::get('/members', 'API\MemberController@all');
    Route::post('/add-member', 'API\MemberController@store');
    Route::delete('/delete-member/{id}', 'API\MemberController@destroy');
    Route::post('/sms/test', 'API\MemberController@smsTest');
    Route::post('/sms/test2', 'API\MemberController@smsTest2');
    Route::get('/sms/test', 'API\MemberController@smsTest');

    // Create Note
    Route::get('/notes/{id}', 'API\DairyController@getNotes');
    Route::post('/note/{id}', 'API\DairyController@postNote');
    Route::delete('/note/{id}', 'API\DairyController@deleteNote');
    Route::put('/note/{id}', 'API\DairyController@updateNote');

    Route::get('/photos/{id}', 'API\DairyController@getPhotos');
    Route::post('/photo/{id}', 'API\DairyController@postPhoto');

    Route::get('/reminder_photos/{id}', 'API\DairyController@getReminderPhotos');
    Route::post('/reminder_photo/{id}', 'API\DairyController@postReminderPhoto');
    // Check In
    Route::post('/checkin/{id}', 'ActivityController@checkin');
    Route::post('/taskcheckin/{id}', 'ActivityController@taskCheckin');
    Route::post('/reminder_checkin/{id}', 'ActivityController@reminder_checkin');
    //Profile
    Route::put('/settings/profile/details', 'API\ProfileDetailsController@update');
    Route::put('/settings/profile/emergency', 'API\ProfileDetailsController@emergency');
    Route::post('/update/about-me', 'API\ProfileDetailsController@updateAboutMe');

    //Contact Photo
    Route::post('/contact/photo', 'API\ContactController@uploadPhoto');

});
