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
    // Соответсвует урл /api/settings
    Route::group(['middleware' => 'auth:api', 'namespace' => 'Settings', 'prefix' => 'settings'], function () {
        //Соответсвует урл /api/settings/ppc
        Route::get('ppc', function (){

        });
    });

    //Без аутентификации
    //Соответсвует урл /api/settings/
    Route::group(['namespace' => 'Settings', 'prefix' => 'settings'], function () {

        //Работа с проксями
        Route::group(['prefix' => 'proxies'], function () {

            //Получение списка проксей /api/settings/proxies/
            Route::get('/', 'ProxiesController@index' );

            //Активация деактивация прокси /api/settings/proxies/{id}/status/
            Route::patch('/{id}/status/', 'ProxiesController@setStatus' )->where('id', '[1-9][0-9]*');

            //Активация деактивация многих проксей /api/settings/proxies/status/
            Route::patch('/status/', 'ProxiesController@setMultiplyStatuses' );

            //Удаление прокси /api/settings/proxies/{id}/
            Route::delete('/{id}/', 'ProxiesController@destroy' )->where('id', '[1-9][0-9]*');

            //Удаление проксей /api/settings/proxies/
            Route::delete('/', 'ProxiesController@destroyMultiply' );

            //Добавление проксей /api/settings/proxies/
            Route::post('/', 'ProxiesController@store' );

            //Обновление прокси /api/settings/proxies/{id}/
            Route::put('/{id}/', 'ProxiesController@update' )->where('id', '[1-9][0-9]*');

        });


        Route::resource('thematics', 'ThematicsController' )
            ->except(['create', 'show', 'edit'])
            ->names('api.settings.thematics');

        Route::resource('domains', 'DomainsRedirectsController' )
            ->except(['create', 'show', 'edit'])
            ->names('api.settings.domains');

    });

    //Работа с сообщениями
    Route::group(['namespace' => 'Messages','prefix' => 'sms-mms-messages/sms/'], function () {

        //Получение списка проксей /api/settings/proxies/
        Route::get('/', 'SmsMmsMessagesController@index' );

        //Активация деактивация прокси /api/settings/proxies/{id}/status/
        Route::patch('/{id}/status/', 'ProxiesController@setStatus' )->where('id', '[1-9][0-9]*');

        //Активация деактивация многих проксей /api/settings/proxies/status/
        Route::patch('/status/', 'ProxiesController@setMultiplyStatuses' );

        //Удаление прокси /api/settings/proxies/{id}/
        Route::delete('/{id}/', 'ProxiesController@destroy' )->where('id', '[1-9][0-9]*');

        //Удаление проксей /api/settings/proxies/
        Route::delete('/', 'ProxiesController@destroyMultiply' );

        //Добавление проксей /api/settings/proxies/
        Route::post('/', 'ProxiesController@store' );

        //Обновление прокси /api/settings/proxies/{id}/
        Route::put('/{id}/', 'ProxiesController@update' )->where('id', '[1-9][0-9]*');

    });

});


//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{any}', 'SpaController@index')->name('spa')->where('any', '.*');;


Auth::routes();

