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

     return redirect(route('chat.client'));
});


Route::get('/testPhp', function ()
{
    $arr = [[2,78,988,99,22,555,6], [3,78,988,99,22,555,6], [4,78,988,99,22,555,6]];

    dd(collect($arr)->random());
});

Route::post('push/welcome', 'Caiji\ApiCommandController@pullGithub');

Route::group(['namespace' => 'Chat', 'prefix' => 'chat', 'middleware' => 'chat'], function(){
    Route::get('chatShow', 'IndexController@chatShow')->name('chat.show');
    Route::post('userUpdate', 'IndexController@userUpdate')->name('chat.customer_update');
});

Route::group(['prefix'=>'chat', 'namespace' => 'Chat'],function (){
    Route::get('login', 'IndexController@login')->name('chat.login');
    Route::post('auth', 'UserDataHandleController@authLogin')->name('chat.auth');
    Route::get('loginOut', 'UserDataHandleController@loginOut')->name('chat.loginOut');
    Route::get('client', 'IndexController@clientChat')->name('chat.client');
    Route::post('uploadFile', 'IndexController@uploadFile')->name('chat.file_upload');
    Route::post('session_record', 'IndexController@sessionRecord')->name('chat.sessionRecord');
    Route::post('update_avatar', 'IndexController@updateAvatar')->name('chat.avatar_update');
});

//重定向 提示信息
Route::get('alert_message', 'RedirectController@index')->name('admin.alert_message');


Route::get('auth/login', function(){
    return view('admin.login');
})->name('admin.login');

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth','checkRole']], function(){
    Route::get('index', 'IndexController@index')->name('admin.index');
    Route::get('welcome', 'IndexController@welcome')->name('admin.welcome');
    Route::get('member', 'IndexController@member_list')->name('admin.memberShow');
    Route::get('memberAdd', 'IndexController@member_add')->name('admin.memberAdd');
    Route::get('member_password', 'IndexController@changePassword')->name('admin.change_password');
    Route::resource('member_logic', 'MemberController');
    Route::post('member_logic/status', 'MemberController@statusEdit')->name('admin.member.statusEdit');
    Route::get('chat_record', 'IndexController@chat_record')->name('admin.chat_record');


    /**
     * 权限
     */
    Route::get('permission_show', 'PermissionController@index')->name('permission.show');
    Route::get('permission-add-show', 'PermissionController@permissionAddShow')->name('permission.add_show');
    Route::post('permission-add-post', 'PermissionController@permissionAddPost')->name('permission.add_post');
    Route::post('permission-delete-post', 'PermissionController@permissionDelete')->name('permission.delete');
    Route::get('permission-edit-show/{id}', 'PermissionController@permissionEditShow')->name('permission.edit_show');
    Route::post('permission-edit-post', 'PermissionController@permissionEditPost')->name('permission.edit_post');


    /**
     * 角色管理
     */
    Route::get('role_show', 'RoleController@index')->name('role.show');
    Route::get('role-add-show', 'RoleController@addShow')->name('role.add_show');
    Route::post('role-add-post', 'RoleController@roleAddPost')->name('role.add_post');
    Route::get('role-edit-show/{id}', 'RoleController@roleEditShow')->name('role.edit_show');
    Route::post('role-edit-post', 'RoleController@roleEditPost')->name('role.edit_post');
    Route::post('role-delete', 'RoleController@roleDelete')->name('role.delete');

    /**
     * 管理员管理
     */
    Route::get('admin-show', 'AdminController@index')->name('admin.show');
    Route::get('admin-add-show', 'AdminController@addShow')->name('admin.add_show');
    Route::post('admin-add-post', 'AdminController@addPost')->name('admin.add_post');
    Route::get('admin-edit-show', 'AdminController@editShow')->name('admin.edit_show');
    Route::post('admin-edit-post', 'AdminController@editPost')->name('admin.edit_post');
    Route::get('admin-change-password-show', 'AdminController@changePasswordShow')->name('admin.change_show');
    Route::post('admin-change-password-post', 'AdminController@changePasswordPost')->name('admin.change_password_post');
    Route::post('admin-disable/{id}','AdminController@userStatusDisable')->name('admin.user_status_disable');
    Route::post('admin-enable/{id}', 'AdminController@userStatusEnable')->name('admin.user_status_enable');
    Route::post('admin-delete/{id}', 'AdminController@delete')->name('admin.delete');

    /**
     * 二维码地址
     */
    Route::get('admin-qrcode-show', 'IndexController@qrcode')->name('admin.qrcode_show');


    Route::get('test', function (\App\Repository\Chat\Member $member)
    {
        dd($member->memberTest());
    });
});

/**
 * 解密 url address
 */
Route::get('qrcode/parse_address/{string}', 'RedirectController@qrcodeDecode')->name('parse.url');

Auth::routes();

Route::get('/home', function (){
    return redirect('admin/index');
})->name('home');

Route::get('test_post', 'PayTestController@pay_test');

Route::group(['prefix'=>'pay'], function(){
    Route::get('register', 'MerchantController@register');
});
