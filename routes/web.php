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
//客户在后台 暂时不能同步 是否在线 只能是活跃
Route::get('/', function(){
     return view('welcome');
});

/*Route::group(['namespace'=>'Caiji'],function (){
    Route::get('active','IndexController@active');

    Route::get('index', 'IndexController@index');

    Route::get('/', 'IndexController@content')->name('active.content');

    Route::get('content/detail', 'IndexController@detail')->name('content.detail');

    Route::post('active/insert','ApiActiveController@insert');

    Route::get('test', 'ApiActiveController@test');

    Route::post('push/welcome', 'ApiCommandController@pullGithub');

    Route::post('command/execute', 'ApiCommandController@testPerformance');
});*/

Route::post('push/welcome', 'Caiji\ApiCommandController@pullGithub');

Route::group(['namespace' => 'Chat', 'prefix' => 'chat', 'middleware' => 'chat'], function(){
    Route::get('chatShow', 'IndexController@chatShow')->name('chat.show');
});

Route::group(['prefix'=>'chat', 'namespace' => 'Chat'],function (){
    Route::get('login', 'IndexController@login')->name('chat.login');
    Route::post('auth', 'UserDataHandleController@authLogin')->name('chat.auth');
    Route::get('loginOut', 'UserDataHandleController@loginOut')->name('chat.loginOut');
    Route::get('client', 'IndexController@clientChat')->name('chat.client');
});



Route::get('auth/login', function(){
    return view('admin.login');
})->name('admin.login');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin','middleware' => 'auth'], function(){
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::get('welcome', 'IndexController@welcome')->name('admin.welcome');
    Route::get('member', 'IndexController@member_list')->name('admin.memberShow');
    Route::get('memberAdd', 'IndexController@member_add')->name('admin.memberAdd');
    Route::get('member_password', 'IndexController@changePassword')->name('admin.change_password');
    Route::resource('member_logic', 'MemberController');
    Route::post('member_logic/status', 'MemberController@statusEdit')->name('admin.member.statusEdit');
    Route::get('chat_record', 'IndexController@chat_record')->name('admin.chat_record');

    Route::get('test', function (\App\Repository\Chat\Member $member)
    {
        dd($member->memberTest());
    });
});

Auth::routes();

Route::get('/home', function (){
    return redirect('admin/index');
})->name('home');


