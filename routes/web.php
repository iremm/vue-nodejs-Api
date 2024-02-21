<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*  NODE JS API-------->server.js    */
Route::get('/', function () {
    return view('welcome');
});
Route::get('/tasks', [TaskController::class, 'tasklist']);
Route::delete('/delete/{id}', [TaskController::class, 'delete']);
Route::put('/update/{id}', [TaskController::class, 'update']);
Route::post('/add', [TaskController::class, 'add']);
Route::post('/upload', [TaskController::class, 'upload']);
