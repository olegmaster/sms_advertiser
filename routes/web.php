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

/**
 * API Routes
 */

//Соответсвует урл /api/
Route::group( ['namespace' => 'Api', 'prefix' => 'api'],function () {

    //Используют аутентификацию
    //Соответсвует урл /api/settings
    Route::group(['middleware' => 'auth:api', 'namespace' => 'Settings', 'prefix' => 'settings'], function () {
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


//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{any}', 'SpaController@index')->name('spa')->where('any', '.*');;


Auth::routes();

