<?php
Route::group(['namespace' => 'Api\auth', 'prefix' => 'api/v1', 'middleware' => ['throttle', 'lang']], function () {
  Route::post('/login', ['uses' => 'LoginController@login']);
  Route::post('/social-login', ['uses' => 'LoginController@socialLogin']);
  Route::post('/refresh-token', ['uses' => 'LoginController@refreshToken']);
  Route::post('/logout', ['uses' => 'LoginController@logout']);
});

