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

function gravatar_url($email) {
    $email = md5($email);
    return "https://gravatar.com/avatar/{$email}?s=60";
}

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){
    Route::resource('projects', 'ProjectController');

    Route::post('/projects/{project}/tasks', 'ProjectTaskController@store');
    Route::patch('/tasks/{task}', 'ProjectTaskController@update');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
