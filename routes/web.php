<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/mobile-home', 'DashboardController@show');
Route::get('/home', 'DashboardController@show');
Route::group(['prefix' => '{team_name}', 'middleware' => ['auth']], function(){
    Route::get('/dashboard', 'DashboardController@home');
    //About-me
    Route::get('/about', 'AboutController@show');
    Route::get('/about/edit', 'AboutController@edit');
    //Activities
    Route::get('/activities', 'ActivityController@list');
    Route::get('/activities/add', 'ActivityController@add');
    Route::get('/activities/view/{id}', 'ActivityController@activity');
    Route::get('/activities/edit/{id}', 'ActivityController@edit');
    Route::get('/reminder/{id}', 'ActivityController@reminder');
    Route::get('/reminder/edit/{id}', 'ActivityController@editReminder');
    Route::get('/diary/edit/{id}', 'ActivityController@editDiary');
    Route::post('/diary/save/{id}', 'ActivityController@diarySaveNote');
    Route::post('/diary/edit/{id}', 'ActivityController@editDiaryNote');
    Route::get('/task/{id}', 'ActivityController@task');
    Route::get('/task/edit/{id}', 'ActivityController@editTask');
    Route::get('/activity/{id}', 'ActivityController@activity');
    Route::get('/reminder/{id}', 'ActivityController@reminder');
    //People
    Route::get('/people', 'PeopleController@show');
    Route::get('/people/add', 'PeopleController@add');
    Route::post('/people/{name}', 'PeopleController@edit');
    //Places
    Route::get('/places', 'PlacesController@show');
    Route::get('/places/add', 'PlacesController@add');
    Route::post('/places/{name}', 'PlacesController@edit');
    //Diary
    Route::get('/diary', 'DashboardController@diary');
    Route::get('/diary_load', 'DashboardController@diary');
    //Gallery
    Route::get('/gallery', 'DashboardController@gallery');
    //Notifications
    Route::get('/notifications', 'DashboardController@notification');
    //Settings
    Route::get('/settings', 'DashboardController@settings');
});

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/switchTeam/{team_id}', 'DashboardController@switchTeam');

Route::post('/activity/create', 'ActivityController@store');
Route::post('/activity/update/{id}', 'ActivityController@updateAppointment');
Route::post('/activity/diary_save/{id}', 'ActivityController@saveDiary');
Route::post('/activity/photo', 'ActivityController@savePhoto');

//Activity
Route::post('/reminder/update/{id}', 'ActivityController@updateReminder');
Route::post("/video-upload" , "ActivityController@videoupload");
Route::get("/video-upload" , "ActivityController@videoupload");

//About
Route::post('/about-me/save', 'AboutController@store');
Route::post('/about-me/photo', 'AboutController@savePhoto');
//People
Route::resource('people', 'PeopleController');
// Route::post('/people/{id}', 'PeopleController@update');
//Places
Route::resource('places', 'PlacesController');

