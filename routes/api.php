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

Route::group(['prefix' => 'bill'], function () {
    Route::post('add', 'BillController@store');
    Route::get('all', 'BillController@showAllCost');
    Route::get('tag/{id}', 'BillController@showTagCost');
    Route::group(['prefix' => 'today'], function () {
        Route::get('/', 'BillController@showTodayCost');
        Route::get('tag', 'BillController@showTodayTagCost');
        Route::get('{role}', 'BillController@showTodayRoleCost');
    });
    Route::group(['prefix' => 'week'], function () {
        Route::get('/', 'BillController@showWeekCost');
        Route::get('tag', 'BillController@showWeekTagCost');
        Route::get('{role}', 'BillController@showWeekRoleCost');
    });
    Route::group(['prefix' => 'month'], function () {
        Route::get('/', 'BillController@showMonthCost');
        Route::get('tag', 'BillController@showMonthTagCost');
        Route::get('{role}', 'BillController@showMonthRoleCost');
    });
    Route::group(['prefix' => 'year'], function () {
        Route::get('/', 'BillController@showYearCost');
        Route::get('tag', 'BillController@showYearTagCost');
        Route::get('{role}', 'BillController@showYearRoleCost');
    });
    Route::put('update/{id}', 'BillController@update');
    Route::delete('delete/{id}', 'BillController@destroy');
});
