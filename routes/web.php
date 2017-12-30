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

//首页
Route::get('/', 'TopicsController@index')->name('root');

Auth::routes();

//用户
Route::resource('users', 'UsersController', ['only' => ['show', 'update', 'edit']]);

//分类
Route::resource('categories', 'CategoriesController', ['only' => 'show']);

//主题
Route::resource('topics', 'TopicsController', ['only' => ['index', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('topics/{topic}/{slug?}', 'TopicsController@show')->name('topics.show');

Route::post('upload_image', 'TopicsController@uploadImage')->name('topics.upload_image');


//测试
Route::get('test', function () {

});

//回复
Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);

//通知
Route::resource('notifications', 'NotificationsController', ['only' => ['index']]);

//无权限提醒页面
Route::get('permission-denied','PagesController@permissionDenied')->name('permission-denied');