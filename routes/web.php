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

Route::get('/', 'DashboardController@index');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::post('/task/filter', 'TaskController@filter')->name('task.filter');
Route::resource('/project', 'ProjectController');
Route::get('history', 'TaskController@history')->name('task.history');
Route::resource('/task', 'TaskController');
Route::get('show_project', 'ProjectController@show');
// Route::patch('/task/filter/{id}',['as' => 'task.filter', 'uses' => 'TaskController@filter']);