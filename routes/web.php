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

Route::group(['namespace'=>'Caiji'],function (){
    Route::get('active','IndexController@active');

    Route::get('index', 'IndexController@index');

    Route::get('/', 'IndexController@content')->name('active.content');

    Route::get('content/detail', 'IndexController@detail')->name('content.detail');

    Route::post('active/insert','ApiActiveController@insert');

    Route::get('test', 'ApiActiveController@test');

    Route::post('push/welcome', 'ApiCommandController@pullGithub');

    Route::post('command/execute', 'ApiCommandController@testPerformance');
});


Route::group(['namespace' => 'Chat', 'prefix' => 'chat'], function(){
    Route::get('index', 'IndexController@index')->name('chat.index');
});