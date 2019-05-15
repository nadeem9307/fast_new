<?php

use Illuminate\Http\Request;

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


Route::post('levels/delete_level','API\ClassAPIController@DeleteLevel')->name('DeleteLevel');
Route::post('sublevels/delete_sublevel','API\ClassAPIController@DeleteSubLevel')->name('DeleteSubLevel');
Route::post('level/add_level','API\ClassAPIController@AddLevel')->name('AddLevel');
Route::post('sublevel/add_sublevel','API\ClassAPIController@AddSubLevel')->name('AddSubLevel');
Route::post('level/update_level','API\ClassAPIController@AddLevel')->name('UpdateLevel');
Route::post('sublevel/update_sublevel','API\ClassAPIController@AddSubLevel')->name('UpdateSubLevel');