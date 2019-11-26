<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
//    dd(app('Fruit')->color);
});
Route::get('/tests', 'Super\TestsController@index');

app();

interface Fruit
{
    public function color();
}

class Apple implements Fruit
{
    public function __construct($color)
    {
        $this->color = $color;
    }

    public function color()
    {
        // TODO: Implement color() method.
        return $this->color;
    }

}

/*app()->bind('Fruit', function()
{
    return new Apple('red');
});*/
app()->bind('Fruit', 'Apple');
app()->when('Apple')->needs('$color')->give('red');


