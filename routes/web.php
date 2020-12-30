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

Route::get('/', function () {
    return view('index');
});

// API(記事)
Route::get('/api/articles', 'api\BlogArticlesController@index');

// API(カテゴリ)
Route::get('/api/pagination', 'api\BlogPaginationController@index');

// 記事
Route::resource('articles', 'ArticlesController');

// 画像
Route::resource('images', 'ImagesController', ['except' => ['edit', 'update']]);

// カテゴリ
Route::resource('categories', 'CategoriesController');