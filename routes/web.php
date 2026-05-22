<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\TaskController; // Bizim yazdığımız denetleyiciyi yukarıya ekledik

// Giriş Sayfası Rotaları
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// GÖREV YÖNETİMİ ROTALARI (Hocanın Klasik Korumalı Rota Grubu Mantığı)
Route::middleware(['auth'])->group(function () {

    // Giriş yapmış her çalışan görev listesini ve detayını görebilir
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/show/{task}', [TaskController::class, 'show'])->name('tasks.show');

    // Hocanın RoleMiddleware Yapısı: Sadece Admin ve Manager görev ekleyebilir, düzenleyebilir veya silebilir
    Route::middleware(['role:admin,manager'])->group(function () {
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks/store', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}/update', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}/delete', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
});
