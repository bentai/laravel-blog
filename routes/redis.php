<?php


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

// 字符串类型 String
Route::prefix('string')->group(function () {
    Route::get('/', 'StringController@index');
});

// 哈希类型 Hash
Route::prefix('hash')->group(function () {
    Route::get('/', 'HashController@index');
});

// 列表类型 List
Route::prefix('list')->group(function () {
    Route::get('/', 'ListController@index');
    Route::get('tests', 'ListController@tests');
});

// 集合类型 Set
Route::prefix('set')->group(function () {
    Route::get('/', 'SetController@index');
});
