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


Route::group(['namespace' => 'Api', 'prefix' => 'v1',  'middleware' => ['lang', 'building_admin']], function () {
    Route::get('guides', 'Guide\GuideController@index');
    Route::get('building-admin', 'buildingAdmin\BuildingAdminApiController@index');
//    Route::put('building-admin', 'buildingAdmin\BuildingAdminApiController@update');


    Route::get('checkinout', 'CheckInOut\CheckInOutApiController@index');
    Route::post('check-in', 'CheckInOut\CheckInOutApiController@postCheckIn');
    Route::post('check-out', 'CheckInOut\CheckInOutApiController@postCheckOut');
    Route::get('check-in-check-out-detail', 'CheckInOut\CheckInOutApiController@detail');
    Route::get('user-check-out', 'CheckInOut\CheckInOutApiController@message');
    Route::get('manuals', 'Manual\ManualController@index');
    Route::post('/verify-user', 'auth\LoginController@verifyUser');
    Route::get('notifications', 'Notification\NotificationController@index');
    Route::get('get-business-check-in', 'CheckInOut\CheckInOutApiController@getBusinessCheckIn');

});

