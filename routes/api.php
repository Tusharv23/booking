<?php

use Illuminate\Http\Request;

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
Route::resource('/property', 'PropertyController');
//This resource can directed by 4 routes:
//1) get:: /api/property -which will list all the properties
//2) get:: /api/property?query[name]=oyo1&query[city]=delhi&query[price]=500 -these are the search query parameters which can be used to search property.
//3) post:: /api/property -this route will store property when hit with proper parameters
//4) get:: /api/property/{id} -this route will list single property whose id is given in the route.
//Go to file propertycontroller for more details.
Route::get('/bookings', 'BookingController@index');
//This route will get all the bookings.
Route::post('/property/{propertyId}/booking','BookingController@store');
//This route will store booking of a user.
Route::get('/property/{propertyId}/booking', 'BookingController@show');
//This route will get bookings of a specific property
//Go to file BookingController for more details.
