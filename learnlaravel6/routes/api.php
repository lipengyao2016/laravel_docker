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

Route::post('login', 'Api\PassportController@login');
Route::post('login2', 'Api\PassportController@login2');

Route::post('register', 'Api\PassportController@register');

Route::get('/users','Api\UserController@index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('multiauth:teacher')->get('/admin', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:api'],function (){
    Route::get('/passportUserInfo','Api\PassportController@getDetails');
});

Route::group(['middleware' => 'auth:api'], function(){
   // Route::post('get-details', 'API\PassportController@getDetails');
    Route::post('logout', 'Api\PassportController@logout');
});

Route::middleware(['auth:teacher,api' /*'multiauth:teacher'*//*,'auth:api'*/ /*'oauth.providers','auth:api'*/])->group(function(){
    Route::get('/get-details', 'Api\PassportController@getDetails');
});