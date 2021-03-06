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
Route::get('/task/filter', 'TaskController@filter')->name('task.filter');
Route::resource('/project', 'ProjectController');
Route::get('history', 'TaskController@history')->name('task.history');
Route::get('/task/show/{task}', 'TaskController@show')->name('task.show');
Route::resource('/task', 'TaskController');
Route::get('show_project', 'ProjectController@show');
// Route::patch('/task/filter/{id}',['as' => 'task.filter', 'uses' => 'TaskController@filter']);
//Route::post('/task/change_receiver/{id_task}/{id_user}', 'TaskController@change_receiver')->name('task.change_receiver');
Route::post('/task/change_receiver', 'TaskController@change_receiver')->name('task.change_receiver');
Route::get('/live_search_user', 'LiveSearchController@action_user')->name('live_search.action_user');
Route::get('/live_search_task', 'LiveSearchController@action_task')->name('live_search.action_task');
