<?php

//use Illuminate\Http\Request;
use Illuminate\Routing\Router;
// Redis

Route::namespace('App\Redis\Controllers')->prefix('redis')->group(function () {
    Route::get('/', 'StringController@index');

});
/*Route::group([
    'prefix'        => 'redis',
    'namespace'     => 'App\\Redis\\Controllers',
], function (Router $router) {

    $router->get('/', 'StringController@index');


});*/
