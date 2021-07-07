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

Route::prefix('admin')->name('admin.')->middleware('isAdmin')->group(function(){
	Route::resource('category','CategoryController');
});

Route::resource('item','ItemController');

Route::resource('comment','CommentController');

Route::resource('favourite','FavouriteController');

Route::resource('order','OrderController');

Route::resource('profile','ProfileController');

Auth::routes();

Route::get('/about','FrontendController@about')->name('about');

Route::get('/contact','FrontendController@contact')->name('contact');

Route::get('/','ItemController@index');

Route::get('itemcategory','ItemController@itemcategory')->name('itemcategory');  

Route::get('/detail', 'ItemController@detail')->name('detail');

Route::get('/getpostitems','ItemController@postitems')->name('getpostitems');

Route::get('/postlist','ItemController@postlist');

Route::post('/favourite','FavouriteController@store');

Route::get('/getfavourite','FavouriteController@favourite')->name('getfavourite');

Route::get('/favouritelist','FavouriteController@index');

Route::get('/getitems','ItemController@getitems')->name('getitems');

Route::post('itemcategory','ItemController@itemcategory');

Route::post('delete','ItemController@destroy')->name('delete');

Route::post('getuser','ProfileController@getuser')->name('getuser');

Route::post('addamount','ItemController@addamount')->name('addamount');

Route::get('search_items','ItemController@search_items')->name('search_items');

Route::post('admin/category/update','CategoryController@update')->name('category_update');

Route::post('admin/category/delete','CategoryController@destroy')->name('category_destroy');

Route::post('/getcategory','CategoryController@getcategory')->name('getcategory');

Route::get('/category','CategoryController@index');

Route::get('/comment','CategoryController@store')->name('comment');

Route::post('/commentstore','CommentController@store')->name('commentstore');

Route::post('/comment/update','CommentController@update')->name('comment_update');

Route::post('/comment/destroy','CommentController@destroy')->name('comment_destroy');

Route::post('/getcomments','CommentController@getcomments')->name('getcomments');

Route::get('/balance','ProfileController@balance');

Route::post('edit','ProfileController@update');

Route::post('add_balance','ProfileController@add_balance')->name('add_balance');

Route::post('sub_balance','ProfileController@sub_balance')->name('sub_balance');

Route::post('order_detail','OrderController@order_detail')->name('order_detail');

Route::get('/orderlist','OrderController@index');

Route::get('/getincommingorder','OrderController@getincommingorder')->name('getincommingorder');

Route::get('/getoutgoingorder','OrderController@getoutgoingorder')->name('getoutgoingorder');

Route::post('/confirmorder','OrderController@confirmorder')->name('confirmorder');

Route::post('/deleteorder','OrderController@deleteorder')->name('deleteorder');






