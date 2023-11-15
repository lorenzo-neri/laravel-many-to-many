<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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


/* Admin routes */
Route::middleware(['auth', 'verified']) #per utenti loggati e verificati
    ->prefix('admin') #prefix degli url iniziano con '/admin/'
    ->name('admin.') #nome delle rotte inizia con 'admin.'
    ->group(function () {
        //after login
        Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

        //admin/projects - show project
        Route::resource('projects', ProjectController::class)->parameters(['projects' => 'project:slug']);

        //amdin/projects/recycle - show trashed projects
        Route::get('projects/recycle', [ProjectController::class, 'recycle'])->name('projects.recycle');

        //restore trashed projects
        Route::get('projects/restore/{id}', [ProjectController::class, 'restore'])->name('projects.restore');
    });


/* Profile views */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
