<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Rutas publicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/plausible-seed', 'debug.plausible-seed')->name('debug.plausible-seed');

// Rutas de autenticacion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/cambiar_contraseña', [LoginController::class, 'changePassword'])->name('changePassword');

Route::middleware('auth')->group(function () {
    Route::get('/seleccionar-rol', [LoginController::class, 'showRoleSelection'])->name('role.selection');
    Route::post('/seleccionar-rol', [LoginController::class, 'selectRole'])->name('role.selection.store');
});

Route::middleware(['role:student'])->group(function () {
    Route::get('/tipos_de_test', fn() => view('student.testTypes'))->name('student.testType');
    Route::get('/classes', [ClassesController::class, 'get'])->name('student.classes');
    Route::post('/classes', [ClassesController::class, 'reservesClass'])->name('student.classes.reserve');
    Route::delete('/classes/{class}', [ClassesController::class, 'cancelReservation'])->name('student.classes.cancel');
    Route::get('/alumno/configuracion', [StudentSettingsController::class, 'show'])->name('student.settings');
    Route::post('/alumno/configuracion/perfil', [StudentSettingsController::class, 'updateProfile'])->name('student.settings.profile');
    Route::post('/alumno/configuracion/seguridad', [StudentSettingsController::class, 'updatePassword'])->name('student.settings.password');
    Route::post('/alumno/configuracion/examenes/{exam}', [StudentSettingsController::class, 'registerExam'])->name('student.settings.exams.register');
    Route::get("/contacto", fn() => view('student.contacto'))->name('student.contacto');
    Route::post("/contacto", [ContactController::class, 'uploadMessage'])->name('student.contacto');
    Route::get('/hacer_tests', [hacerTestController::class, 'showTests'])->name('student.test');
    Route::get('/haciendo_test', [haciendoTestController::class, 'showquestions'])->name('student.complete_test');
    Route::get('/resultados', [ResultsController::class, 'get'])->name('student.result');
    Route::post('/resultados', [ResultsController::class, 'upload'])->name('student.result');
    Route::get('/test_corregido', [ResultsController::class, 'correctTests'])->name('student.showCorrectedTest');
});

Route::middleware(['role:teacher'])->group(function() {
    Route::get('/teacher/dashboard', [EmployeesPlaceController::class, 'getStudents'])->name('teacher.dashboard');
    Route::get('/teacher/questions', [EmployeesPlaceController::class, 'getQuestions'])->name('teacher.questions');
    Route::post('/teacher/questions/answer', [EmployeesPlaceController::class, 'answerStudentQuestion'])->name('teacher.questions.answer');
    Route::get('/crear_tests', fn() => view('teacher.createTests'))->name('teacher.createTests');
    Route::post('/crear_tests', [CrearTestsController::class, 'crear_tests'])->name('teacher.createTests');

    Route::get('/create_classes', [CrearClassController::class,'get'])->name('teacher.createClasses');
    Route::post('/create_classes', [CrearClassController::class,'upload'])->name('teacher.createClasses');
});

Route::middleware(['role:administrator'])->group(function() {
    Route::get('/admin/dashboard', [EmployeesPlaceController::class, 'getTeachers'])->name('admin.dashboard');
    Route::post('/admin/dashboard/stats', [EmployeesPlaceController::class, 'getStats'])->name('admin.dashboard');
    Route::post('/admin/dashboard/details', [EmployeesPlaceController::class, 'getDetails'])->name('admin.dashboard');
    Route::get('/create_user', [CreateUserController::class, 'get'])->name('admin.createUser');
    Route::post('/create_user', [CreateUserController::class, 'upload'])->name('admin.createUser');
    Route::get('/create_timetable', fn() => view('admin.createTimetable'))->name('admin.createTimetable');
    Route::post('/create_timetable', [CreateTimetableController::class, 'upload'])->name('admin.createTimetable');
});
