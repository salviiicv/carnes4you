<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TpvSessionController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'role:employee,admin'])->group(function () {
    Route::get('/tpv', [TpvSessionController::class, 'index'])->name('tpv.index');
    Route::post('/tpv/abrir', [TpvSessionController::class, 'store'])->name('tpv.store');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return 'Zona admin';
    });
});

require __DIR__.'/auth.php';
