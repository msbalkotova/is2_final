<?php

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

Route::get('/', 'EmployeeController@index');

Route::post('/', 'EmployeeController@search');

Route::get('/employee/{emp}', 'StatisticController@getSingleStats');

Route::get('/employees/{dept}', 'StatisticController@getOverallStats');

Route::get('/statistics', 'StatisticController@index');