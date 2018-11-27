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



Route::any('/login','LoginController@login');

Route::get('/captcha/{tmp}','LoginController@captcha');

Route::group(["namespace"=>'Index',"middleware"=>'adminAuth'], function (){
    /**
     * 访问路径是:/index
     */
    Route::get('/', "IndexController@index");
    Route::get('/home', "IndexController@home");
});

