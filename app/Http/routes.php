<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
//用户进入商城页
Route::group(['middleware' => 'shop'] , function () {
	//路由组 post get 都能进入
	Route::any('/shop','ShopController@index');
});


Route::group(['middleware' => ['web', 'throttle:20,1']], function () {
    //只有游客才能访问的页面
    Route::group(['middleware' => 'guest:web'], function () {
        //用户注册登录
        Route::get('/register', 'UserController@showRegisterForm');
        Route::post('/register', 'UserController@doRegister');
        Route::get('/login', 'UserController@showLoginForm');
        Route::post('/login', 'UserController@auth');
    });

    //只有登录之后才能访问的页面
    Route::group(['middleware' => 'auth:web'], function () {
        Route::get('/logout', 'UserController@logout');
    });

    //其它权限在各自控制器里定义
    //帖子相关操作
    Route::get('/', 'PostController@index');
    Route::get('/post/create', 'PostController@create');
    Route::post('/post/create', 'PostController@store');
    Route::get('/post/{id}/edit', 'PostController@edit');
    Route::get('/post/{id}/delete', 'PostController@delete');
    Route::get('/post/essentials', 'PostController@essential');
    Route::get('/post/{id}/essential/{method}', 'PostController@setEssential');
    Route::get('/post/{id}/Top/{method}', 'PostController@setTop');
    Route::get('/post/{id}/like', 'PostController@like');
    Route::get('/post/{id}/favourite', 'PostController@favourite');
    Route::PATCH('/post/{id}', 'PostController@update');
    Route::get('/post/{id}', 'PostController@show');
    Route::get('/tags/{name}','PostController@tags');
    Route::get('/search','PostController@search');

    //评论相关操作
    Route::post('/comment', 'CommentController@store');
    Route::get('/comment/{id}/like', 'CommentController@like');

    //站内消息
    Route::get('/user/messages', 'ProfileController@showMessages');
    Route::post('/user/messages', 'ProfileController@sentMessage');
    Route::get('/user/messages/{id}/delete', 'ProfileController@deleteMessage');
    Route::get('/user/message/{id}', 'ProfileController@readMessage');
    Route::post('/usr/message/{id}', 'ProfileController@replyMessage');


    //显示用户信息
    Route::get('/user/{id}/replies', 'ProfileController@replies');
    Route::get('/user/{id}/favourites', 'ProfileController@favourites');
    Route::get('/user/update', 'ProfileController@showUpdateForm');
    Route::post('/user/update', 'ProfileController@update');
    Route::get('/user/{id}', 'ProfileController@index');


});

//没有访问频率限制的前台页面
Route::group(['middleware' => 'web'], function () {
    Route::post('/post/preview/{type}', 'PostController@preview');
});

//后面管理页面
Route::group(['middleware' => ['web', 'throttle:30,1']], function () {
    Route::get('/admin', 'AdminController@index');
    Route::post('/admin', 'AdminController@auth');
    Route::get('/admin/home', 'AdminController@home');
    Route::get('/admin/logout', 'AdminController@logout');
    Route::post('/admin/searchUser', 'AdminController@searchUser');
    Route::put('/admin/updateUser', 'AdminController@updateUser');
    Route::get('/admin/messageManagement', 'AdminController@messageManagement');
    Route::post('/admin/sendMessage', 'AdminController@doSendMessage');
    Route::get('/admin/Msg/delAllMsg', 'AdminController@delAllMsg');
    Route::get('/admin/Msg/delUnreadMsg', 'AdminController@delUnreadMsg');
    Route::get('/admin/Msg/delReadMsg', 'AdminController@delReadMsg');
    Route::get('/admin/Msg/delMonthMsg', 'AdminController@delMonthMsg');
    Route::get('/admin/Announce', 'AdminController@announce');
    Route::post('/admin/Announce', 'AdminController@addAnnounce');
    Route::get('/admin/Announce/{id}/delete', 'AdminController@delAnnounce');
    Route::get('/admin/Announce/{id}', 'AdminController@editAnnounce');
    Route::put('/admin/Announce/{id}', 'AdminController@updateAnnounce');
    Route::get('/admin/tags', 'AdminController@tags');
    Route::post('/admin/tags', 'AdminController@addTag');
    Route::get('/admin/tags/{id}/delete', 'AdminController@delTags');
    Route::put('/admin/tags/{id}/update', 'AdminController@updateTags');
    Route::get('/admin/tags/{id}', 'AdminController@editTags');


});
