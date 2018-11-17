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
Route::redirect('/', '/articles', '301');

Route::get('/signup', 'RegisterController@index')->name('signup');
Route::get('/login', 'LoginController@index')->name('login');
Route::post('/signin', 'LoginController@signin')->name('signin');
Route::get('logout', 'LoginController@logout')->name('logout');

Route::get('/password_reset', 'ResetPasswordController@index')->name('password_reset');

Route::post('/signup_check/mobile', 'RegisterController@validateMobile')->name('validateCode_check');
Route::get('/user_info/{user}', 'RegisterController@showUserInfoForm')->name('register_user_info');
Route::put('/user_info/{user}', 'UsersController@save')->name('user_info');
Route::get('/user/{mobile}', 'UsersController@info')->name('user.info');

// Auth::routes();
Route::get('/articles', 'ArticlesController@index')->name('articles');
Route::get('/articles/{article}', 'ArticlesController@show')->name('show');

Route::post('/comments', 'CommentsController@store')->name('comments.store');
Route::get('/comments/{comment}', 'CommentsController@show')->name('comments.show');

Route::get('/topics', 'TopicsController@index')->name('topics');
Route::get('/topics/{topic}', 'TopicsController@show')->name('topics.show');

Route::post('/replies', 'RepliesController@store')->name('replies.store');
Route::get('/replies', 'RepliesController@show')->name('replies.show');

//个人中心路由组
Route::get('/user/{mobile}/topics','UsersController@showTopics')->name('user.topics');
Route::get('/user/{mobile}/comments','UsersController@showComments')->name('user.comments');
Route::get('/user/{mobile}/edit', 'UsersController@edit')->name('user.edit');
Route::put('/user/{mobile}/update', 'UsersController@update')->name('user.update');




