<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

//Route::resource('tasks', 'App\Http\Controllers\TasksController')->middleware('auth');

Route::get('/tasks', 'App\Http\Controllers\TasksController@index')->name('tasks.index');
Route::post('/tasks', 'App\Http\Controllers\TasksController@sortBy')->name('tasks.sortby');
Route::get('/tasks/create', 'App\Http\Controllers\TasksController@create')->name('tasks.create');
Route::post('/tasks/create', 'App\Http\Controllers\TasksController@store')->name('tasks.store');
Route::get('/tasks/{id}/edit', 'App\Http\Controllers\TasksController@edit');
Route::patch('/tasks/{id}', 'App\Http\Controllers\TasksController@update')->name('tasks.update');
Route::delete('/tasks/delete/{id}', 'App\Http\Controllers\TasksController@destroy');



Route::get('/', function () {
    return redirect()->route('/tasks.index');
});

Auth::routes();

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
