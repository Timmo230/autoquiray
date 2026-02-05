<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rutas publicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get("/contacto", fn() => view('contacto'))->name('contacto');

// Rutas de autenticacion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['role:student'])->group(function () {
    Route::get('/test', fn() => view('student.test'))->name('student.test');
    Route::get('/classes', fn() => view('student.classes'))->name('student.classes');
});

Route::middleware(['role:teacher'])->group(function() {
    Route::get('/dashboard', fn() => view('teacher.dashboard'))->name('teacher.dashboard');
});

Route::middleware(['role:administrator'])->group(function() {
    Route::get('/panel', fn() => view('admin.dashboard'))->name('admin.dashboard');
});