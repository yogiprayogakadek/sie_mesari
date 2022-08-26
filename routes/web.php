<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'Main\DashboardController@index')->middleware('auth')->name('dashboard.index');

Route::middleware('auth')->namespace('Main')->group(function() {
    Route::prefix('/dashboard')->name('dashboard.')->group(function() {
        Route::get('/', 'DashboardController@index')->name('index');
    });

    Route::prefix('/category')->name('category.')->group(function() {
        Route::get('/', 'CategoryController@index')->name('index');
        Route::get('/render', 'CategoryController@render')->name('render');
        Route::get('/create', 'CategoryController@create')->name('create');
        Route::post('/store', 'CategoryController@store')->name('store');
        Route::get('/edit/{id}', 'CategoryController@edit')->name('edit');
        Route::post('/update', 'CategoryController@update')->name('update');
        Route::get('/delete/{id}', 'CategoryController@delete')->name('delete');
    });

    Route::prefix('/product')->name('product.')->group(function() {
        Route::get('/', 'ProductController@index')->name('index');
        Route::get('/render', 'ProductController@render')->name('render');
        Route::get('/create', 'ProductController@create')->name('create');
        Route::post('/store', 'ProductController@store')->name('store');
        Route::get('/edit/{id}', 'ProductController@edit')->name('edit');
        Route::post('/update', 'ProductController@update')->name('update');
        Route::get('/delete/{id}', 'ProductController@delete')->name('delete');
    });

    Route::prefix('/member')->name('member.')->group(function() {
        Route::get('/', 'MemberController@index')->name('index');
        Route::get('/render', 'MemberController@render')->name('render');
        Route::get('/create', 'MemberController@create')->name('create');
        Route::post('/store', 'MemberController@store')->name('store');
        Route::get('/edit/{id}', 'MemberController@edit')->name('edit');
        Route::post('/update', 'MemberController@update')->name('update');
        Route::get('/delete/{id}', 'MemberController@delete')->name('delete');
    });

    Route::prefix('/sale')->name('sale.')->group(function() {
        Route::get('/', 'SaleController@index')->name('index');
        Route::get('/search-product/{slug}', 'SaleController@search')->name('search');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
