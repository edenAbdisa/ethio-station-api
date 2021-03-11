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
Route::get('/users','UserController@index');
Route::post('/users','UserController@store');
Route::post('/users/login','UserController@login');
Route::post('/users/logout','UserController@logout');

Route::get('/rate','RateController@index');
Route::get('/rate/{id}','RateController@show');
Route::post('/rate','RateController@store');
Route::put('/rate/{id}','RateController@update');
Route::delete('/rate/{id}','RateController@destroy');

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

Route::get('/categories','CategoriesController@index');
Route::get('/categories/{id}','CategoriesController@show');
Route::post('/categories','CategoriesController@store');
Route::put('/categories/{id}','CategoriesController@update');
Route::delete('/categories/{id}','CategoriesController@destroy');