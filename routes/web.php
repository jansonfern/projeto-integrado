<?php

use App\Http\Controllers\Api\CepController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rotas de autenticação com rate limiting
Route::middleware(['throttle:10,1'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// API pública com rate limiting
Route::middleware(['throttle:30,1'])->group(function () {
    Route::get('api/cep/{cep}', [CepController::class, 'show']);
});

// Rotas autenticadas com rate limiting
Route::middleware(['auth', 'throttle.auth'])->group(function () {
    // Rotas para Administradores
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::resource('patients', PatientController::class);
        Route::resource('doctors', DoctorController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::get('documentation/pdf', [DocumentationController::class, 'generatePDF'])->name('documentation.pdf');
    });

    // Rotas para Médicos
    Route::middleware(['auth', 'role:medico'])->group(function () {
        Route::get('my-schedules', [ScheduleController::class, 'index'])->name('my-schedules');
        Route::post('appointments/{appointment}/confirm', [AppointmentController::class, 'confirm'])->name('appointments.confirm');
    });

    // Rotas para Pacientes
    Route::middleware(['auth', 'role:paciente'])->group(function () {
        Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/available', [AppointmentController::class, 'availableSlots'])->name('appointments.available');
        Route::post('appointments/quick-book', [AppointmentController::class, 'quickBook'])->name('appointments.quick-book');
    });

    // Rotas gerais
    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::post('appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    Route::get('certificates/{appointment}/generate', [CertificateController::class, 'generate'])->name('certificates.generate');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('api/schedules/available-times', [ScheduleController::class, 'getAvailableTimes'])->name('schedules.available-times');

    // Rotas de perfil (admin/medico)
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
