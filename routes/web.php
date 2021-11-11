<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
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

Route::get('/', function (): \Illuminate\Contracts\View\View {
    return view('index');
})->name('index');

// Task statuse routes
Route::resource('task_statuses', TaskStatusController::class);

// Task routes
Route::resource('tasks', TaskController::class);

// Label routes
Route::resource('labels', LabelController::class);

require __DIR__ . '/auth.php';
