<?php

use Illuminate\Http\Request;

// Envolvemos todo en el middleware 'cors' que acabas de registrar
// Route::group(['middleware' => ['cors']], function () {
    
//     Route::post('register', 'API\AuthController@register');
//     Route::post('login', 'API\AuthController@login');

//     Route::group(['middleware' => ['jwt.verify']], function() {
//         Route::get('user', 'API\AuthController@getAuthenticatedUser');   
//         Route::apiResource('authors', 'API\AuthorController');
//         Route::apiResource('books', 'API\BookController');
//     });
// });


Route::post('register', 'API\AuthController@register');
Route::post('login', 'API\AuthController@login');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('user', 'API\AuthController@getAuthenticatedUser');   
    Route::apiResource('authors', 'API\AuthorController');
    Route::apiResource('books', 'API\BookController');
});