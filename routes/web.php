<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::patch('tasks/{task}/assign', [TaskController::class, 'assign'])->name('tasks.assign');
Route::get('tasks/{task}/assignview', [TaskController::class, 'assignview'])->name('tasks.assignview');
Route::patch('tasks/{task}/unassign', [TaskController::class, 'unassign'])->name('tasks.unassign');
Route::get('tasks/{task}/unassignview', [TaskController::class, 'unassignview'])->name('tasks.unassignview');
Route::post('/tasks/{id}/change-status', [TaskController::class, 'changeStatus'])->name('tasks.changeStatus');

Route::resource('tasks', TaskController::class)
    ->only(['index', 'edit', 'create', 'update', 'store', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__.'/auth.php';
