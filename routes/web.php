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


Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('index');

Route::get('dashboard', \App\Livewire\DashBoardPage::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', \App\Livewire\Profile::class)
    ->middleware(['auth'])
    ->name('profile');


require __DIR__ . '/auth.php';
