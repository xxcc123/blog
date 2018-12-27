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

//Route::get('/', function () {
////    return view('welcome');
//});




/*Route::get('/',function(){
    Route::get('/client','Backend\User\UserController@clientApi');

})->middleware('api');*/
//Route::group(['middleware' => 'auth:api'],function(){
Route::group(['middleware' => 'api'],function(){
    Route::get('/tokenapi','Backend\User\UserController@tokenApi');
});

//Route::get('/tokenapi','Backend\User\UserController@tokenApi')->middleware('api');

Route::group(['middleware' => 'auth'],function(){

    Route::get('/api','Backend\User\UserController@getApi');

    Route::get('/newapi','Backend\User\UserController@userApi');

    Route::get('/clientapi','Backend\User\UserController@clientApi');



//    Route::get('/','Backend\User\UserController@user');
});
//});

// First route that user visits on consumer app
/*Route::get('/', function () {
    // Build the query parameter string to pass auth information to our request
    $query = http_build_query([
        'client_id' => 1,
        'redirect_uri' => 'http://consumer.dev/auth/callback',
        'response_type' => 'code',
        'scope' => 'conference'
    ]);

    // Redirect the user to the OAuth authorization page
    return redirect('http://passport.dev/oauth/authorize?' . $query);
});*/

Auth::routes();

//后台路由
Route::group(['middleware' => 'auth'], function () {
    //用户
    Route::get('/home', 'HomeController@index')->name('admin.home');
    Route::get('/user', 'Backend\User\UserController@index')->name('user');
    Route::get('/user_search', 'Backend\User\UserController@search')->name('user_search');
    Route::post('/user', 'Backend\User\UserController@fileload')->name('user');
    Route::get('/user_show', 'Backend\User\UserController@show')->name('user_show');
    Route::get('/user_detail/{id}', 'Backend\User\UserController@detail')->name('user_detail');
    Route::get('/user_update{id}', 'Backend\User\UserController@update')->name('user_update');
    Route::get('/user_destroy/{id}', 'Backend\User\UserController@destroy')->name('user_destroy');

    //文章
    Route::get('artisan', 'Backend\ArtisanController@index')->name('artisan.index');
    Route::get('artisan_search', 'Backend\ArtisanController@search')->name('artisan.search');
    Route::post('artisan_excel_import', 'Backend\ArtisanController@excel_import')->name('artisan_excel_import');
    Route::get('artisan_excel_export', 'Backend\ArtisanController@excel_export')->name('artisan_excel_export');
    Route::get('artisan/create', 'Backend\ArtisanController@create')->name('artisan_create');
    Route::post('artisan/store', 'Backend\ArtisanController@store')->name('artisan_store');
    Route::get('artisan/show/{id}', 'Backend\ArtisanController@show')->name('artisan.show');
    Route::post('artisan/update/{id}', 'Backend\ArtisanController@update')->name('artisan.update');
    Route::get('artisan/destroy/{id}', 'Backend\ArtisanController@destroy')->name('artisan.destroy');

//    类别
    Route::resource('category', 'Backend\CategoryController',['names'=>[
        'index' => 'category.list',
        'create' => 'category.create',
        'store' => 'category.store',
        'show' =>  'category.show',
        'edit' => 'category.edit',
        'update' => 'category.update',
        'destroy' => 'category.destroy'
    ]]);
    Route::get('category_search', 'Backend\CategoryController@search')->name('category.search');

    Route::get('pdf', 'Backend\ArtisanController@pdf')->name('pdf');

    Route::post('image', 'Backend\ArtisanController@image')->name('upload.image');
});

Route::get('/admin/login', 'Backend\LoginController@login_view')->name('admin.login');
Route::get('/admin/register', 'Backend\LoginController@register_view')->name('admin.register');
Route::post('/admin/login', 'Backend\LoginController@login')->name('admin/login');
Route::post('/admin/register', 'Backend\LoginController@register')->name('admin/register');
Route::get('/admin', 'Backend\IndexController@index')->name('admin.index');



//前台路由

//注册登录路由
Route::get('front_register', 'LoginController@register_view')->name('register.view');
Route::post('front_register', 'LoginController@register')->name('register.post');
Route::get('front_login', 'LoginController@login_view')->name('login.view');
Route::post('front_login', 'LoginController@login')->name('login.post');
//退出路由
Route::get('loginout','LoginController@loginout')->name('loginout');
//发送重置密码链接路由
Route::get('forget_password', 'LoginController@forget_password')->name('forget.password');
Route::post('retrieve_password', 'LoginController@retrieve_password')->name('retrieve.password');
//重置密码路由
Route::get('reset/passwords/{email}', 'ResetPasswordsController@reset_passwords_view')->name('reset.passwords');
Route::post('reset_passwords', 'ResetPasswordsController@reset_passwords')->name('reset.passwords.post');

Route::get('/', 'ArtisanController@index')->name('home');
Route::get('blog/{id}', 'ArtisanController@show')->name('show');
Route::get('/{name}', 'ArtisanController@search')->name('artisan.index.search');
//评论路由
Route::post('/comment/store', 'CommentController@store')->name('comment.store');
Route::get('comment', 'CommentController@index')->name('comment.list');
//联系方式路由
Route::get('contact/me', 'ContactController@index')->name('contact.me');
Route::post('contact/email/send', 'ContactController@email_send')->name('contact.email');

Route::get('login/weixin', 'LoginController@weixinlogin')->name('weixin');
Route::get('login/weixin/callback', 'LoginController@weixinCallback')->name('weixin.callback');


//laravel 日志
Route::get('logs/log', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->name('logs.log');


//redis测试路由
Route::get('test/redis', 'RedisController@testRedis')->name('redis');
Route::get('test/show/redis', 'RedisController@testRedis')->name('show/redis');
