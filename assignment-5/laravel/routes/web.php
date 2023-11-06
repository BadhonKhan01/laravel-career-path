<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WorkExperienceController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/work-experience', [WorkExperienceController::class, 'index'])->name('work.experience');
Route::get('/my-projects', [ProjectController::class, 'index'])->name('projects.list');
Route::get('/project/{slug}', [ProjectController::class, 'detail'])->name('projects.detail');
