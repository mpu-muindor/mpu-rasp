<?php

use App\Jobs\UpdateGroupRaspJob;
use App\Models\Group;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/debug/get_group', function () {
    //$group = Group::whereTitle('171-372')->first();
    //UpdateGroupRaspJob::dispatch($group, $session = false);
});
Route::get('/debug/farm', function () {
    \App\Jobs\UpdateGroupListJob::dispatch()->chain([new \App\Jobs\UpdateScheduleJob()]);
});
Route::get('/debug/get_groups', function () {
    // \App\Jobs\UpdateGroupListJob::dispatch();
    return response()->json(Group::all());
});
Route::get('/debug/get_group/{group_title}', function ($group_title) {
    $group = Group::whereTitle($group_title)->with(['lessons' => function ($query) {
        /** @var $query Illuminate\Database\Eloquent\Relations\HasMany */
        $query->orderBy('day_number')->orderBy('lesson_number')->orderBy('date_from');
    }])->get();

    return response()->json($group);
});

Route::get('/home', 'HomeController@index')->name('home');
