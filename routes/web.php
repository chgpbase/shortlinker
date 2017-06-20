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
    return view('home');
})->name('home');

Route::post('shorten', 'ShortLinkController@shorten')->name('shorten');
Route::get('statistic/{short}/{key}', 'ShortLinkController@statistic')->name('statistic');
Route::get('{short}', 'ShortLinkController@hit');
