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

Route::group(['namespace'=>'Caiji'],function (){
    Route::get('active','IndexController@index');

    Route::get('content', 'IndexController@content')->name('active.content');

    Route::get('content/detail', 'IndexController@detail')->name('content.detail');

    Route::post('active/insert','ApiActiveController@insert');

    Route::get('test', 'ApiActiveController@test');

    Route::post('push/welcome', 'ApiCommandController@pullGithub');
});
