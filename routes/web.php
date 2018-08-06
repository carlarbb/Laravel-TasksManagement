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
Route::get('/task/change_receiver/{id_task}/{id_user}', 'TaskController@change_receiver')->name('task.change_receiver');
Route::get('/live_search', 'LiveSearchController@action')->name('live_search.action');