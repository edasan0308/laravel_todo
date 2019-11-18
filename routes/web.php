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

#MethodがGETで/folders/{id}/tasksにリクエストがきた時、TaskControllerクラスのindexメソッドを呼び出す。このルーティングの名前をtasks.indexとしている。
Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');

//FOLDER作成ページ
Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
Route::post('/folders/create', 'FolderController@create');

//TASK作成ページ
Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
Route::post('/folders/{id}/tasks/create', 'TaskController@create');

//TASK編集ページ
Route::get('/folders/{id}/tasks/edit', 'TaskController@showEditForm')->name('tasks.edit');
Route::post('/folders/{id}/tasks/edit', 'TaskController@edit');