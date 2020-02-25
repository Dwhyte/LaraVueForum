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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@authUser');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoryController@allCategories');
 });


Route::group(['prefix' => 'thread'], function () {
    Route::get('{category}', 'ThreadController@getAllThreads');
    Route::get('{username}/{slug}', 'ThreadController@getSingleThread');
    Route::post('create', 'ThreadController@createThread');
//    Route::get('mine', 'ThreadController@AuthUserThreads');
    Route::post('save', 'ThreadController@saveThread');
    Route::post('remove', 'ThreadController@removeThread');
});


Route::post('likeIt', 'LikeController@likeIt');
Route::delete('unlikeIt', 'LikeController@unLikeIt');


Route::group(['prefix' => 'reply'], function () {
   Route::post('add', 'ReplyController@createReply');
   Route::post('remove', 'ReplyController@removeReply');
});
