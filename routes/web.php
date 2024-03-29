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

Route::group(['middleware' => 'auth'], function() {

    //ホームページ
    Route::get('/', 'HomeController@index')->name('home');

    #TASK一覧ページ
    Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');

    //FOLDER作成ページ
    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    //TASK作成ページ
    Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
    Route::post('/folders/{id}/tasks/create', 'TaskController@create');

    //TASK編集ページ
    Route::get('/folders/{id}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
    Route::post('/folders/{id}/tasks/{task_id}/edit', 'TaskController@edit');

    //TASK削除
    Route::get('/folders/{id}/tasks/{task_id}/delete', 'TaskController@delete')->name('tasks.delete');
});

//認証用
Auth::routes();