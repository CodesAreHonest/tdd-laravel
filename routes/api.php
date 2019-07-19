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

Route::group(['prefix' => 'food'], function() {

    Route::post('/insert', 'FoodController@addFood')->name('add.food');
    Route::put('/update', 'FoodController@editFood');
    Route::get('/list', 'FoodController@getFood');
    Route::delete('/delete', 'FoodController@deleteFood');

});
