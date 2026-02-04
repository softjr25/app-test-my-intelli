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

Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login');

// Rutas que requieren que el usuario esté logueado
Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'API\AuthController@getAuthenticatedUser');   
    // Aquí irán las rutas de Libros y Autores después
    Route::apiResource('authors', 'API\AuthorController');
    Route::apiResource('books', 'API\BookController');
});
