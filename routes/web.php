<?php

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



Route::view('/', 'welcome');

Route::get('/courses/{course}', \App\Livewire\ShowCourse::class)->name('courses.show');
Route::get('/courses/{course}/episodes/{episode?}', \App\Livewire\WatchEpisode::class)
    ->middleware(['auth'])
    ->name('courses.episodes.show');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
