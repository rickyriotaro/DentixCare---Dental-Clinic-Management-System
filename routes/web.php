<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VisitReportController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DokterAppointmentController;
use App\Http\Controllers\DokterMedicalRecordController;
use App\Http\Controllers\DokterTreatmentPlanController;
use App\Http\Controllers\DokterPatientControlController;
use App\Http\Controllers\DokterRiwayatPerawatanController;
use App\Http\Controllers\DokterManagementController;



    Route::get('/', fn () => redirect()->route('login'));

    Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'process'])->name('login.process');
});
/**  logout harus bisa untuk semua user yg sudah login */
    Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
    /**  ADMIN */
    Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /**  biar /admin/dashboard tidak 404 */
    Route::get('/admin/dashboard', fn() => redirect()->route('dashboard'));

    Route::resource('patients', PatientController::class);
    // pendaftaran pasien
    Route::get('/pendaftaran', [RegistrationController::class, 'create'])->name('pendaftaran.create');
    Route::post('/pendaftaran', [RegistrationController::class, 'store'])->name('pendaftaran.store');
    // janji temu 
    Route::get('/janji-temu', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/janji-temu/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/janji-temu/{appointment}/approve', [AppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/janji-temu/{appointment}/reject', [AppointmentController::class, 'reject'])->name('appointments.reject');
    // rekam medis
    Route::get('/rekam-medis', [MedicalRecordController::class, 'index'])->name('rekammedis.index');
    Route::get('/rekam-medis/create', [MedicalRecordController::class, 'create'])->name('rekammedis.create');
    Route::post('/rekam-medis', [MedicalRecordController::class, 'store'])->name('rekammedis.store');
    Route::get('/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('rekammedis.show');
    Route::get('/rekam-medis/{medicalRecord}/input', [MedicalRecordController::class, 'input'])->name('rekammedis.input');
    Route::post('/rekam-medis/{medicalRecord}/input', [MedicalRecordController::class, 'saveInput'])->name('rekammedis.saveInput');
    Route::get('/rekam-medis/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('rekammedis.edit');
    Route::put('/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('rekammedis.update');
    Route::delete('/rekam-medis/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('rekammedis.destroy');
    // API: Get latest medical record for auto-fill
    Route::get('/api/rekam-medis/latest/{patientId}', [MedicalRecordController::class, 'getLatestData'])->name('rekammedis.latest.data');
    // notifikasi
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
    // laporan kunjungan
    Route::get('/laporan-kunjungan', [VisitReportController::class, 'index'])->name('reports.visits.index');
    Route::get('/laporan-kunjungan/filter', [VisitReportController::class, 'filter'])->name('reports.visits.filter');
    Route::post('/laporan-kunjungan/simpan', [VisitReportController::class, 'save'])->name('reports.visits.save');
    // kelola dokter
    Route::resource('dokters', DokterManagementController::class)->except(['show', 'create', 'edit']);
    
    // FHIR Explorer (Inline - No Controller)
    Route::get('/fhir-explorer', function() {
        return view('fhir.explorer');
    })->name('fhir.explorer');
});
    /** DOKTER */
    Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {
    Route::get('/dashboard', [DokterController::class, 'index'])->name('dashboard');
    // janji temu dokter
    Route::get('/janji-temu', [DokterAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/janji-temu/{appointment}', [DokterAppointmentController::class, 'show'])->name('appointments.show');
    Route::post('/janji-temu/{appointment}/approve', [DokterAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::post('/janji-temu/{appointment}/reject', [DokterAppointmentController::class, 'reject'])->name('appointments.reject');
    });
    // REKAM MEDIS DOKTER 
    Route::middleware(['auth','role:dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {
    // data rekam medis dokter
    Route::get('/rekam-medis', [DokterMedicalRecordController::class,'index'])->name('rekammedis.index');
    Route::get('/rekam-medis/{medicalRecord}', [DokterMedicalRecordController::class,'show'])->name('rekammedis.show');
    Route::get('/rekam-medis/{medicalRecord}/input', [DokterMedicalRecordController::class,'input'])->name('rekammedis.input');
    Route::post('/rekam-medis/{medicalRecord}/input', [DokterMedicalRecordController::class, 'saveInput'])->name('rekammedis.saveInput');
    Route::put('/rekam-medis/{medicalRecord}', [DokterMedicalRecordController::class,'update'])->name('rekammedis.update');
});

Route::middleware(['auth','role:dokter'])
  ->prefix('dokter')
  ->name('dokter.')
  ->group(function () {
    // ... route dokter lain
    // rencana perawatan gigi
    Route::get('/perawatan-gigi', [DokterTreatmentPlanController::class, 'index'])->name('perawatan.index');
    Route::get('/perawatan-gigi/{medicalRecord}', [DokterTreatmentPlanController::class, 'show'])->name('perawatan.show');
    Route::get('/perawatan-gigi/{medicalRecord}/create', [DokterTreatmentPlanController::class, 'create'])->name('perawatan.create');
    Route::post('/perawatan-gigi/{medicalRecord}', [DokterTreatmentPlanController::class, 'store'])->name('perawatan.store');
    Route::patch('/perawatan-gigi/plan/{plan}/complete', [DokterTreatmentPlanController::class, 'complete'])->name('perawatan.complete');
  });
    Route::middleware(['auth', 'role:dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {
    //  KONTROL PASIEN
    Route::get('/kontrol-pasien', [DokterPatientControlController::class, 'index'])->name('kontrol.index');
    Route::get('/kontrol-pasien/{medicalRecord}', [DokterPatientControlController::class, 'show'])->name('kontrol.show');
    Route::get('/kontrol-pasien/{medicalRecord}/create', [DokterPatientControlController::class, 'create'])->name('kontrol.create');
    Route::post('/kontrol-pasien/{medicalRecord}', [DokterPatientControlController::class, 'store'])->name('kontrol.store');
    });
    Route::middleware(['auth','role:dokter'])
    ->prefix('dokter')
    ->name('dokter.')
    ->group(function () {
    // riwayat perawatan
    Route::get('/riwayat-perawatan', [DokterRiwayatPerawatanController::class,'index'])->name('riwayat.index');
    Route::get('/riwayat-perawatan/{medicalRecord}', [DokterRiwayatPerawatanController::class,'show'])->name('riwayat.show');
    });

