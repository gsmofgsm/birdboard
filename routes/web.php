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

\App\Project::created(function($project){
    \App\Activity::create([
        'project_id' => $project->id,
        'description' => 'created'
    ]);
});
\App\Project::updated(function($project){
    \App\Activity::create([
        'project_id' => $project->id,
        'description' => 'updated'
    ]);
});

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/projects/create', 'ProjectController@create');
    Route::get('/projects/{project}', 'ProjectController@show');
    Route::get('/projects/{project}/edit', 'ProjectController@edit');
    Route::patch('/projects/{project}', 'ProjectController@update');
    Route::get('/projects', 'ProjectController@index');
    Route::post('/projects', 'ProjectController@store');
    Route::post('/projects/{project}/tasks', 'ProjectTaskController@store');
    Route::patch('/tasks/{task}', 'ProjectTaskController@update');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
