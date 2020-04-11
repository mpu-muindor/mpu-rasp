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
    Route::get('/suggest', 'RaspApiController@getSuggest')->name('suggest');
    Route::prefix('professors')->name('professors.')->group(static function () {
        Route::get('/', 'ProfessorApiController@index')->name('index');
        Route::get('/{professor:full_name}', 'ProfessorApiController@show')->name('show');
        Route::get('/{professor:full_name}/lessons', 'ProfessorApiController@getLessons')->name('lessons');
    });
    Route::prefix('groups')->name('groups.')->group(static function () {
        Route::get('/', 'GroupApiController@index')->name('index');
        Route::get('/{group:title}', 'GroupApiController@show')->name('show');
        Route::get('/{group:title}/lessons', 'GroupApiController@getLessons')->name('lessons');
    });
});
