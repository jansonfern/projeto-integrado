<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\CepController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentationController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Rota de debug temporária
Route::get('/debug', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'role_check_admin' => $user->role === 'admin',
            'role_check_medico' => $user->role === 'medico',
            'role_check_paciente' => $user->role === 'paciente',
        ]);
    }
    return response()->json(['error' => 'Não logado']);
})->middleware('auth');

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
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
    Route::get('api/cep/{cep}', [CepController::class, 'show']);
    Route::get('api/schedules/available-times', [ScheduleController::class, 'getAvailableTimes'])->name('schedules.available-times');

    // Rotas de perfil (admin/medico)
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
});
