<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/validateCode', 'Api\VerificationCodesController@store')->name('validateCode');
Route::post('/replyComment', 'Api\RepliesController@store')->name('replyComment');

Route::post('/fileUpload', 'Api\FileUploadController@store')->name('fileUpload');



