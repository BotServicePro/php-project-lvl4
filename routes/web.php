<?php

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

Route::get('/', function () {
    return view('index');
})->name('index');

// Task statuse routes
Route::resource('task_statuses', TaskStatusController::class);
//Route::get('task_statuses', [TaskStatusController::class, 'index'])->name('task_statuses.index');
//Route::post('task_statuses', [TaskStatusController::class, 'store'])->middleware('auth')->name('task_statuses.store');
//Route::get('task_statuses/create', [TaskStatusController::class, 'create'])->middleware('auth')->name('task_statuses.create');
//Route::get('task_statuses/{task_status}', [TaskStatusController::class, 'show'])->name('task_statuses.show');
//Route::patch('task_statuses/{task_status}', [TaskStatusController::class, 'update'])->middleware('auth')->name('task_statuses.update');
//Route::get('task_statuses/{task_status}/edit', [TaskStatusController::class, 'edit'])->middleware('auth');
//Route::delete('task_statuses/{task_status}', [TaskStatusController::class, 'destroy'])->middleware('auth')->name('task_statuses.destroy');

require __DIR__.'/auth.php';
