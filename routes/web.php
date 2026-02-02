<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'lagout'])->name('logout');

Route::middleware(['auth'])->group(function(){
    Route::get('/dashboard', function(){
        $user = Auth::user();
        
        if($user->type === 'administrator') return redirect('/admin/panel');
        if($user->type === 'teacher') return redirect('teacher/panel');
        return redirect('/student/panel');
    })->name('dashboard');
});

Route::get('/tests', fn() => view('tests'))->name('tests');

Route::get('/classes', fn() => view('classes'))->name('classes');

Route::get("/contacto", fn() => view('contacto'))->name('contacto');

Route::get("/teacher/dashboard", fn() => view('teacher/dashboard'))->name('teacher/dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/classes', fn() => view('classes'));
//     Route::get('/tests', fn() => view('tests'));
// });

// Route::middleware(['auth','role:teacher'])->group(function () {
//     Route::get('/zona-profesores', fn() => view('teacher.dashboard'));
// });