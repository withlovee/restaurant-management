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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->group(function () {
    Route::get('admin/restaurant/{id?}', 'RestaurantController@index')->name('restaurant-index');
    Route::post('admin/restaurant/{id?}', 'RestaurantController@store')->name('restaurant-store');
    Route::delete('admin/restaurant/{id?}', 'RestaurantController@destroy')->name('restaurant-destroy');
});