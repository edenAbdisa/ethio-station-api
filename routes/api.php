<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/user','UserController@index');
Route::post('/user','UserController@store');
Route::post('/user/login','UserController@login');
Route::post('/user/logout','UserController@logout');

Route::get('/bookedcar','BookedcarController@index');
Route::get('/bookedcar/{id}','BookedcarController@show');
Route::post('/bookedcar','BookedcarController@store');
Route::put('/bookedcar/{id}','BookedcarController@update');
Route::delete('/bookedcar/{id}','BookedcarController@destroy');

Route::get('/car','CarController@index');
Route::get('/car/{id}','CarController@show');
Route::post('/car','CarController@store');
Route::put('/car/{id}','CarController@update');
Route::delete('/car/{id}','CarController@destroy');

Route::get('/category','CategoryController@index');
Route::get('/category/{id}','CategoryController@show');
Route::post('/category','CategoryController@store');
Route::put('/category/{id}','CategoryController@update');
Route::delete('/category/{id}','CategoryController@destroy');

Route::get('/hiking','HikingController@index');
Route::get('/hiking/{id}','HikingController@show');
Route::get('/hiking/name/{name}','HikingController@showbyname');
Route::post('/hiking','HikingController@store');
Route::put('/hiking/{id}','HikingController@update');
Route::delete('/hiking/{id}','HikingController@destroy');

Route::get('/hotel','HotelController@index');
Route::get('/hotel/name/{name}','HotelController@showbyname');
Route::get('/hotel/{id}','HotelController@show');
Route::post('/hotel','HotelController@store');
Route::put('/hotel/{id}','HotelController@update');
Route::delete('/hotel/{id}','HotelController@destroy');

Route::get('/language','LanguageController@index');
Route::get('/language/{id}','LanguageController@show');
Route::post('/language','LanguageController@store');
Route::put('/language/{id}','LanguageController@update');
Route::delete('/language/{id}','LanguageController@destroy');

Route::get('/media','MediaController@index');
Route::get('/media/{id}','MediaController@show');
Route::post('/media','MediaController@store');
Route::put('/media/{id}','MediaController@update');
Route::delete('/media/{id}','MediaController@destroy');


Route::get('/membership','MembershipController@index');
Route::get('/membership/{id}','MembershipController@show');
Route::post('/membership','MembershipController@store');
Route::put('/membership/{id}','MembershipController@update');
Route::delete('/membership/{id}','MembershipController@destroy');

Route::get('/rate','RateController@index');
Route::get('/rate/{id}','RateController@show');
Route::post('/rate','RateController@store');
Route::put('/rate/{id}','RateController@update');
Route::delete('/rate/{id}','RateController@destroy');

Route::get('/restaurant','RestaurantController@index');
Route::get('/restaurant/{id}','RestaurantController@show');
Route::get('/restaurant/name/{name}','RestaurantController@showbyname');
Route::post('/restaurant','RestaurantController@store');
Route::put('/restaurant/{id}','RestaurantController@update');
Route::delete('/restaurant/{id}','RestaurantController@destroy');

Route::get('/subscription','SubscriptionController@index');
Route::get('/subscription/{id}','SubscriptionController@show');
Route::post('/subscription','SubscriptionController@store');
Route::put('/subscription/{id}','SubscriptionController@update');
Route::delete('/subscription/{id}','SubscriptionController@destroy');

Route::get('/tourguide','TourguideController@index');
Route::get('/tourguide/{id}','TourguideController@show');
Route::get('/tourguide/name/{name}','TourguideController@showbyname');
Route::post('/tourguide','TourguideController@store');
Route::put('/tourguide/{id}','TourguideController@update');
Route::delete('/tourguide/{id}','TourguideController@destroy');

Route::get('/tourguidelanguage','TourGuideLController@index');
Route::get('/tourguidelanguage/{id}','TourGuideLController@show');
Route::post('/tourguidelanguage','TourGuideLController@store');
Route::put('/tourguidelanguage/{id}','TourGuideLController@update');
Route::delete('/tourguidelanguage/{id}','TourGuideLController@destroy');

Route::get('/type','TypeController@index');
Route::get('/type/{id}','TypeController@show');
Route::post('/type','TypeController@store');
Route::put('/type/{id}','TypeController@update');
Route::delete('/type/{id}','TypeController@destroy');

Route::get('/usertransaction','UserTransactionController@index');
Route::get('/usertransaction/{id}','UserTransactionController@show');
Route::post('/usertransaction','UserTransactionController@store');
Route::put('/usertransaction/{id}','UserTransactionController@update');
Route::delete('/usertransaction/{id}','UserTransactionController@destroy');