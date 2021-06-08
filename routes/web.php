<?php

use Illuminate\Support\Facades\Route;

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

Route::get('generate-shorten-link', 'App\Http\Controllers\ShortLinkController@index');
Route::post('generate-shorten-link', 'App\Http\Controllers\ShortLinkController@store')->name('generate.shorten.link.post');

Route::get('{code}', 'App\Http\Controllers\ShortLinkController@shortenLink')->name('shorten.link');
