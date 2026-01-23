<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home'));

Route::get('/login', fn() => view('auth.login'))->name('login');

Route::get('/contacto', fn() => view('contact'));

Route::middleware('auth')->group(function () {
    Route::get('/classes', fn() => view('classes'));
    Route::get('/tests', fn() => view('tests'));
});

Route::middleware(['auth','role:teacher'])->group(function () {
    Route::get('/zona-profesores', fn() => view('teacher.dashboard'));
});