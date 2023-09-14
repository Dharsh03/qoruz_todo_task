<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create_task', 'TaskAndSubTask\TaskAndSubTaskController@createTask');

Route::post('/create_sub_task', 'TaskAndSubTask\TaskAndSubTaskController@createSubTask');

Route::post('/delete_task', 'TaskAndSubTask\TaskAndSubTaskController@deleteTask');

Route::post('/list_task', 'TaskAndSubTask\TaskAndSubTaskController@listTask');

Route::post('/update_task', 'TaskAndSubTask\TaskAndSubTaskController@updateTask');
