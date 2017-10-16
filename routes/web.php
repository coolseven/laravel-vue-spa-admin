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


// captcha img
Route::get('captcha/{config?}',['uses'=>'\Mews\Captcha\CaptchaController@getCaptcha','meta' => ['description' => '登录验证码'] ])->name('app.captcha');




// Warning: this route SHOULD always be the last route , any route below it will be ignored!!
Route::any('{else}',['uses'=>'AppController@index','meta' => ['description' => '应用首页'] ])->where('else','.*')->name('app');
