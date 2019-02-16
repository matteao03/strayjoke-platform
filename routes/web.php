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

//web首页 
Route::redirect('/', 'articles', 301);

/**
 * Auth 相关路由
 * 登录、注册、找回密码、退出等路由
 */

//登录
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('loginCode', 'Auth\LoginController@sendCode'); //获取短信验证码
Route::post('code_login', 'Auth\LoginController@codeLogin')->name('code_login');

//注册
Route::get('join', 'Auth\RegisterController@showRegisterForm')->name('join'); //致敬github
Route::post('join', 'Auth\RegisterController@join');
Route::post('registerCode', 'Auth\RegisterController@sendCode');
Route::get('auth_info', 'Auth\RegisterController@showAuthInfoForm');
Route::post('auth_info', 'UsersController@store');

//找回密码
Route::get('password_forget', 'Auth\ResetPasswordController@showForgetPasswordForm')->name('password_forget');
Route::post('mobile_verify', 'Auth\ResetPasswordController@verifyMobile');
Route::post('resetCode', 'Auth\ResetPasswordController@sendCode');
Route::get('password_reset', 'Auth\ResetPasswordController@showResetPasswordForm')->name('password_reset');
Route::post('password_reset', 'Auth\ResetPasswordController@resetPassword');
//退出
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//会员
Route::get('users/{user}', 'UsersController@show')->name('users.show');
Route::get('users/{user}/edit', 'UsersController@edit')->name('users.edit');
Route::patch('users/{user}', 'UsersController@update')->name('users.update');
Route::patch('user/unbindMobile', 'UsersController@unbindMobile')->name('user.unbindMobile');//解绑手机

//律师认证
Route::get('lawyers', 'LawyersController@create')->name('lawyers.create');
Route::get('lawyers/{lawyer}/edit', 'LawyersController@edit')->name('lawyers.edit');
Route::post('lawyers', 'LawyersController@store')->name('lawyers.store');
Route::put('lawyers/{lawyer}', 'LawyersController@update')->name('lawyers.update');

//文章
Route::get('articles', 'ArticlesController@index')->name('articles');
Route::get('articles/create', 'ArticlesController@create')->name('articles.create');
Route::get('articles/{article}/edit', 'ArticlesController@edit')->name('articles.edit');
Route::post('articles/store', 'ArticlesController@store')->name('articles.store');
Route::put('articles/{article}/update', 'ArticlesController@update')->name('articles.update');
Route::delete('articles/{article}', 'ArticlesController@destory')->name('articles.destory');
Route::get('articles/{article}', 'ArticlesController@detail')->name('articles.detail');

Route::middleware(['auth'])->group(function() {
    Route::post('articles/{article}/collect', 'ArticlesController@collect')->name('articles.collect');
    Route::delete('articles/{article}/unCollect', 'ArticlesController@unCollect')->name('articles.unCollect');
    Route::post('articles/{id}/like', 'ArticlesController@like'); //更新redis点赞记录
    Route::delete('articles/{id}/unLike', 'ArticlesController@unLike'); 
});

Route::get('articles/{id}/comments', 'CommentsController@show')->name('comments.show');
Route::post('comments', 'CommentsController@store')->name('comments.store');
Route::get('comments/{id}/replies', 'CommentsController@showReplies');

//Route::get('/comments/{comment}', 'CommentsController@show')->name('comments.show');

Route::post('replies', 'RepliesController@store')->name('replies.store');

//Route::get('/articles/{article}', 'ArticlesController@show')->name('articles.show');
Route::post('upload_image', 'ArticlesController@uploadImage')->name('articles.upload_image');



//订单路由
Route::post('/orders', 'OrdersController@store')->name('orders.store');
 //跳转支付宝
Route::get('/payment/{order}/alipay', 'PaymentController@payByAlipay')->name('payment.alipay');
Route::get('/payment/alipay/return', 'PaymentController@alipayReturn')->name('payment.alipay.return');

Route::post('/payment/alipay/notify', 'PaymentController@alipayNotify')->name('payment.alipay.notify');
