<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::get('api/:version/banner/:id', 'api/:version.Banner/getBanner');

Route::get('api/:version/theme', 'api/:version.Theme/getThemes');
Route::get('api/:version/theme/:id', 'api/:version.Theme/getProducts');

Route::group('api/:version/product',function(){
    Route::get('/new', 'api/:version.Product/getNewProducts');
    Route::get('/byCategory/:id', 'api/:version.Product/getByCategory');
    Route::get('/:id', 'api/:version.Product/getDetail');
});

//Route::get('api/:version/product/new', 'api/:version.Product/getNewProducts');
//Route::get('api/:version/product/byCategory/:id', 'api/:version.Product/getByCategory');
//Route::get('api/:version/product/:id', 'api/:version.Product/getDetail');

Route::get('api/:version/category/all', 'api/:version.Category/getCategories');

Route::post('api/:version/token/user', 'api/:version.Token/getToken');

Route::post('api/:version/address', 'api/:version.UserAddress/createOrUpdateAddress');

Route::post('api/:version/order', 'api/:version.Order/placeOrder');

Route::get('api/:version/test', 'api/:version.TestAll/test');
