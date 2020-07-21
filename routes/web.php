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

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{any}', 'SpaController@index')->name('spa')->where('any', '.*');;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


$groupData = [
    'namespace' => 'Settings\Thematics',
    'prefix' => 'settings'
];

Route::group($groupData, function () {

    // Settings thematics
    Route::resource('thematics', 'ThematicsController')
        ->names('settings.thematics');


});
