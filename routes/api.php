<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');

Route::get('/', 'ArticleController@index');

Route::get('/show/{id}', 'ArticleController@show');

Route::group(['middleware' => 'checktoken'], function() {

	Route::post('/logout', 'AuthController@logout');

	// Route::post('/refresh', 'AuthController@refresh');

	Route::post('/store', 'ArticleController@store');

	Route::group(['middleware' => 'ChangeArticle'] ,function() {

		Route::post('/update/{id}', 'ArticleController@update');

		Route::post('/destroy/{id}', 'ArticleController@destroy');
	});

});