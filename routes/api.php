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

// Route::middleware('auth:api')->get ('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', 'AuthController@register');

Route::post('/login', 'AuthController@login');

Route::post('/', 'ArticleController@index');

Route::post('/show/{id}', 'ArticleController@show');

Route::group(['middleware' => ['checktoken', 'auth.jwt']], function() {

	Route::post('/logout', 'AuthController@logout');

	Route::post('/refresh', 'AuthController@refresh');

	Route::post('/me', 'AuthController@me');

	Route::post('/payload', 'AuthController@payload');

	Route::group(['middleware' => 'ChangeArticle'] ,function() {

		Route::post('/store', 'ArticleController@store');

		Route::post('/update', 'ArticleController@update');

		Route::post('/destroy', 'ArticleController@destroy');
	});

});