<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return 'Página de Login provisional. <br><a hreF="/">Volver al inicio</a>';
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', function () {
        return view('client.dashboard');
    })->name('client.dashboard');
});

Route::middleware(['auth', 'role:admin,employee'])->group(function () {
    Route::get('/tpv', function () {
        return view ('tpv.index');
    })->name('tpv.index');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});