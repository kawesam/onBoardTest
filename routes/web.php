<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/activation/{token}', 'Auth\RegisterController@activateUser')->name('user.activate');

Route::post('/jobs_page','NavigationController@selectJob');
Route::post('/experience','NavigationController@selectExperience');
Route::post('/freelancer','NavigationController@isFreelancer');
Route::post('/completion','NavigationController@successCompletion');
Route::post('/approval','NavigationController@approveAccount');

Route ::get('/report','NavigationController@showReports');
