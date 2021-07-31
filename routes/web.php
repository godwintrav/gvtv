<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth:admin']], function(){

    Route::view("/admin/upload-video", 'admin.upload-video');
    Route::view("/admin/upload-advert", 'admin.upload-advert');
    Route::view("/admin/test", 'admin.test');
    

    Route::post('/admin/set_upload_video', 'AdminController@setUploadVideo');
    Route::post('/admin/upload_media', 'AdminController@uploadVideo');
    Route::post("/admin/search", 'AdminController@searchVideo');
    Route::post('/admin/upload_advert', 'AdminController@UploadAdvert');
    
    //goes to index page of admin 
    Route::get('/admin/index', 'AdminController@index');
    Route::get('/admin/allusers', 'AdminController@allusers');
    Route::get('/admin/logout', 'AdminController@logout');
    Route::get('/admin/upload/{id}', 'AdminController@redirectToUploadView');
    Route::get("/admin/video/{id}", 'AdminController@viewMedia');
    Route::get("/admin/ad/{id}", 'AdminController@loadAdPage');
    Route::get("/admin/view-adverts", 'AdminController@viewAdverts');
    Route::get("/admin/disableAd/{id}", 'AdminController@disableAd');
    Route::get("/admin/activateAd/{id}", 'AdminController@activateAd');
    Route::get("/admin/deleteUser/{id}", 'AdminController@deleteUser');
});

Route::group(['middleware' => ['auth:viewer']], function(){
    //goes to index page of viewer
    Route::get("/", 'UserController@index');
    Route::get('/viewer/index', 'UserController@index');
    Route::get('/viewer/logout', 'UserController@logout');
    Route::get("/viewer/video/{id}", 'UserController@viewMedia');
    Route::get("/viewer/ad/{id}", 'UserController@loadAdPage');
    Route::get("/viewer/addPlaylist/{id}", 'UserController@addToPlaylist');
    Route::get("/viewer/playlist", 'UserController@user_playlist');
    Route::get("/viewer/delete_media/{id}", 'UserController@delete_media');
    Route::get("/viewer/payment/{id}", 'UserController@paymentPage');
    Route::get("/viewer/addLikes/{id}", 'UserController@addLikes');

    Route::post("/viewer/search", 'UserController@searchVideo');
    Route::post('/viewer/confirm-payment', 'UserController@confirmPayment');
    
    
    

});

//Route::get('/{num}','Tutorial@show')->middleware('age');

Route::view("/admin_login", 'admin.login')->name('admin_login');
Route::view("/admin_register", 'admin.register');
Route::view("/viewer_register", 'viewer.register');
Route::view("/viewer_login", 'viewer.login')->name('viewer_login');

//Route::view("/admin/upload", 'admin.upload')->middleware('auth');

Auth::routes();

//Route::get('/home', 'UserController@index')->name('home');




Route::post('/register_admin', 'AdminController@register');
Route::post('/login_admin', 'AdminController@login');
Route::post('/register_viewer', 'UserController@register');
Route::post('/login_viewer', 'UserController@login');

