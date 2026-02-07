<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\hacerTestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rutas publicas
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticacion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['role:student'])->group(function () {
    Route::get('/tipos_de_test', fn() => view('student.testTypes'))->name('student.testType');
    Route::get('/classes', fn() => view('student.classes'))->name('student.classes');
    Route::get("/contacto", fn() => view('student.contacto'))->name('student.contacto');
    Route::get('/hacer_tests', [hacerTestController::class, 'showTests'])->name('student.test');
});

Route::middleware(['role:teacher'])->group(function() {
    Route::get('/dashboard', fn() => view('teacher.dashboard'))->name('teacher.dashboard');
});

Route::middleware(['role:administrator'])->group(function() {
    Route::get('/panel', fn() => view('admin.dashboard'))->name('admin.dashboard');
});