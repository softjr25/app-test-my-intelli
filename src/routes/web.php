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
    return view('welcome');
});

Route::get('/admin', function () {
    // Aquí podrías pasar los conteos reales a la vista más adelante
    return view('admin.index');
});

Route::get('admin/books', 'Admin\BookController@index')->name('books.index');
