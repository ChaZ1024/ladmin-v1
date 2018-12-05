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

Route::group(["namespace"=>'Admin'], function (){

    Route::any('/login','LoginController@login');
    Route::any('/noauth','CommonController@noauth');
    Route::get('/captcha/{tmp}','CommonController@captcha');
    Route::get('/map','CommonController@map');
});




Route::group(["namespace"=>'Admin',"middleware"=>'adminAuth'], function (){
    /**
     * 访问路径是:/
     */
    Route::any('/uploadImg','CommonController@uploadImg')->name('uploadImg');


    Route::get('/', "IndexController@index");
    Route::get('/home', "IndexController@home");




    Route::group(["prefix"=>'shop'], function (){
        /**
         * 访问路径是:/shop
         */

        Route::any('/list',"ShopController@index")->name('shopList');
        Route::any('/add',"ShopController@shopAdd")->name('shopAdd');
        Route::any('/eidt',"ShopController@shopEdit")->name('shopEdit');
        Route::any('/del',"ShopController@shopDel")->name('shopDel');
    });

    Route::group(["prefix"=>'clean'], function (){
        /**
         * 访问路径是:/clean
         */

        Route::any('/list',"CleanController@index")->name('cleanList');

    });



    Route::group(["prefix"=>'miniapp'], function (){
        /**
         * 访问路径是:/miniapp
         */

        Route::any('/conf',"MiniappController@conf")->name('miniappConf');

    });



    /**
     * 系统设置路由
     */
    Route::group(["prefix"=>'sys'], function (){
        /**
         * 访问路径是:/auth/node
         */

        Route::any('/base',"SysController@base")->name('sysBase');
        Route::any('/custom',"SysController@custom")->name('sysCustom');
        Route::any('/smtp',"SysController@smtp")->name('sysSmtp');


    });


    /**
     * 权限管理
     */
    Route::group(["prefix"=>'auth'], function (){
        /**
         * 访问路径是:/auth
         */

        Route::get('/node',"AuthController@node")->name('authNode');

        Route::group(["prefix"=>'node'], function (){
            /**
             * 访问路径是:/auth/node
             */

            Route::any('/add',"AuthController@nodeAdd")->name('authNodeAdd');
            Route::post('/del',"AuthController@nodeDel")->name('authNodeDel');
            Route::any('/edit', "AuthController@nodeEdit")->name('authNodeEdit');


        });




        Route::get('/admin',"AuthController@admin")->name('authAdmin');

        Route::group(["prefix"=>'admin'], function (){
            /**
             * 访问路径是:/auth/admin
             */

            Route::any('/add',"AuthController@adminAdd")->name('authAdminAdd');
            Route::post('/del',"AuthController@adminDel")->name('authAdminDel');
            Route::any('/edit', "AuthController@adminEdit")->name('authAdminEdit');


        });




        Route::get('/role', "AuthController@role")->name('authRole');


        Route::group(["prefix"=>'role'], function (){
            /**
             * 访问路径是:/auth/role
             */

            Route::any('/add',"AuthController@roleAdd")->name('authRoleAdd');
            Route::post('/del',"AuthController@roleDel")->name('authRoleDel');
            Route::any('/edit', "AuthController@roleEdit")->name('authRoleEdit');
            Route::any('/auth', "AuthController@roleAuthEdit")->name('authRoleAuthEdit');


        });

    });

});

