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

Route::prefix('rasp')->name('rasp.')->group(static function () {
    Route::get('/suggest', 'Api\RaspController@getSuggest')->name('suggest');
    Route::get('/search', 'Api\RaspController@getSearch')->name('search');

    Route::prefix('professors')->name('professors.')->group(static function () {
        Route::get('/', 'Api\ProfessorController@index')->name('index');
        Route::get('/{professor:full_name}', 'Api\ProfessorController@show')->name('show');
        Route::get('/{professor:full_name}/lessons', 'Api\LessonsController@getProfessorLessons')->name('lessons');
    });

    Route::prefix('groups')->name('groups.')->group(static function () {
        Route::get('/', 'Api\GroupController@index')->name('index');
        Route::get('/{group:title}', 'Api\GroupController@show')->name('show');
        Route::get('/{group:title}/lessons', 'Api\LessonsController@getGroupLessons')->name('lessons');
    });
});
