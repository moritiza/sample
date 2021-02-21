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

/*
|--------------------------------------------------------------------------
| Management Routes
|--------------------------------------------------------------------------
*/

Route::namespace('App\Http\Controllers\Api\V1\Management')
    ->prefix('v1/management')
    ->group(
        function () {
            /* ------------------- Product Routes ------------------- */
            Route::get('/products', 'ProductController@index');
            Route::put('/products/{id}', 'ProductController@update');

            /* ------------------- Vote Routes ------------------- */
            Route::get('/votes', 'VoteController@index');
            Route::put('/votes/{id}', 'VoteController@update');

            /* ------------------- Comment Routes ------------------- */
            Route::get('/comments', 'CommentController@index');
            Route::put('/comments/{id}', 'CommentController@update');
        }
    );

/*
|--------------------------------------------------------------------------
| Management Routes
|--------------------------------------------------------------------------
*/

Route::namespace('App\Http\Controllers\Api\V1\User')
    ->prefix('v1/user')
    ->group(
        function () {
            /* ------------------- Product Routes ------------------- */
            Route::get('/products', 'ProductController@index');
            Route::get('/products/{id}', 'ProductController@show');

            /* ------------------- Review Routes ------------------- */
            Route::get('/products/{id}/control', 'ReviewController@control');
            Route::get('/products/{id}/rates', 'ReviewController@rates');
            Route::get('/products/{id}/comments', 'ReviewController@lastComments');

            /* -------------------  Routes ------------------- */
            Route::post('/comments', 'FeedbackController@storeComment');
            Route::post('/votes', 'FeedbackController@storeVote');
        }
    );

/*
|--------------------------------------------------------------------------
| PingPong Route
|--------------------------------------------------------------------------
*/

Route::get('/ping', function () {
    return response()->json('pong', 200);
});
