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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/**
 * API Routes
 */
Route::namespace('Api')
    ->group( ['prefix' => 'api'],function () {

        //Используют аутентификацию
        //Соответсвует урл /api/settings
        Route::group(['middleware' => 'auth:api', 'prefix' => 'settings'], function () {
            //Соответсвует урл /api/settings/ppc
            Route::get('ppc', function (){

            });
        });

        //Без аутентификацию
        //Соответсвует урл /api/settings/
        Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {
            //Соответсвует урл /api/settings/proxies
            Route::get('proxies', 'ProxiesController@index' );
        });
});
