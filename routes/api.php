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

Route::get('/tests', 'Super\TestsController@index');
Route::get('/tests/{id}', 'Super\TestsController@show');
Route::post('/tests', 'Super\TestsController@store');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
