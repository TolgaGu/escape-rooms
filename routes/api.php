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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'App\Http\Controllers\AuthController@login');


Route::middleware('auth:sanctum')->group(function () {

    Route::get('/escape-rooms', 'App\Http\Controllers\EscapeRoomsController@index');
    Route::get('/escape-rooms/{id}', 'App\Http\Controllers\EscapeRoomsController@show');
    Route::get('/escape-rooms/{id}/time-slots', 'App\Http\Controllers\EscapeRoomsController@timeSlots');
    
    Route::get('/bookings', 'App\Http\Controllers\BookingsController@index');
    Route::post('/bookings', 'App\Http\Controllers\BookingsController@store');
    Route::delete('/bookings/{id}', 'App\Http\Controllers\BookingsController@destroy');

});
