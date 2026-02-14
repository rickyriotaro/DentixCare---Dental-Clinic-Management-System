<?php

use App\Http\Controllers\Api\ApiAuth;
use App\Http\Controllers\Api\PatientProfileController;
use App\Http\Controllers\Api\PatientAppointmentController;
use App\Http\Controllers\Api\PatientMedicalRecordController;
use App\Http\Controllers\Api\PatientNotificationController;
use App\Http\Controllers\Api\PatientTreatmentPlanController;
use App\Http\Controllers\Api\PatientControlController;
use Illuminate\Support\Facades\Route;

/**
 * ===========================
 * PUBLIC ROUTES (No Auth)
 * ===========================
 */
Route::post('/login', [ApiAuth::class, 'login']);
Route::post('/register', [ApiAuth::class, 'register']);

/**
 * ===========================
 * PROTECTED ROUTES (Auth Required)
 * ===========================
 */
Route::middleware('auth:sanctum')->group(function () {
    
    // ==================
    // AUTH
    // ==================
    Route::post('/logout', [ApiAuth::class, 'logout']);
    
    // ==================
    // PROFILE
    // ==================
    Route::get('/patient/profile', [PatientProfileController::class, 'show']);
    Route::put('/patient/profile', [PatientProfileController::class, 'update']);
    Route::put('/patient/change-password', [PatientProfileController::class, 'changePassword']);
    
    // ==================
    // APPOINTMENTS
    // ==================
    Route::get('/patient/appointments/upcoming', [PatientAppointmentController::class, 'upcoming']);
    Route::get('/patient/appointments', [PatientAppointmentController::class, 'index']);
    Route::post('/patient/appointments', [PatientAppointmentController::class, 'store']);
    Route::get('/patient/appointments/{id}', [PatientAppointmentController::class, 'show']);
    Route::delete('/patient/appointments/{id}', [PatientAppointmentController::class, 'destroy']);
    
    // ==================
    // MEDICAL RECORDS
    // ==================
    Route::get('/patient/medical-records', [PatientMedicalRecordController::class, 'index']);
    Route::get('/patient/medical-records/{id}', [PatientMedicalRecordController::class, 'show']);
    
    // ==================
    // NOTIFICATIONS
    // ==================
    Route::get('/patient/notifications/recent', [PatientNotificationController::class, 'recent']);
    Route::get('/patient/notifications', [PatientNotificationController::class, 'index']);
    Route::put('/patient/notifications/{id}/read', [PatientNotificationController::class, 'markAsRead']);
    Route::delete('/patient/notifications/{id}', [PatientNotificationController::class, 'destroy']);
    
    // ==================
    // TREATMENT PLANS
    // ==================
    Route::get('/patient/treatment-plans', [PatientTreatmentPlanController::class, 'index']);
    Route::get('/patient/treatment-plans/{id}', [PatientTreatmentPlanController::class, 'show']);
    
    // ==================
    // PATIENT CONTROLS
    // ==================
    Route::get('/patient/controls', [PatientControlController::class, 'index']);
    Route::get('/patient/controls/{id}', [PatientControlController::class, 'show']);
    
    // ==================
    // DASHBOARD
    // ==================
    Route::get('/patient/upcoming-schedules', [App\Http\Controllers\Api\PatientDashboardController::class, 'upcomingSchedules']);
    
});

/**
 * ===========================
 * FHIR ENDPOINTS (Public - for interoperability)
 * ===========================
 * FHIR Spec: http://hl7.org/fhir/
 */
use App\Http\Controllers\Api\FHIRController;

// FHIR Metadata (CapabilityStatement)
Route::get('/fhir/metadata', [FHIRController::class, 'getCapabilityStatement']);

// FHIR Patient Resource
Route::get('/fhir/Patient/{id}', [FHIRController::class, 'getPatient']);
Route::get('/fhir/Patient', [FHIRController::class, 'getAllPatients']);
Route::get('/fhir/Patient/{id}/$everything', [FHIRController::class, 'getPatientEverything']);

// FHIR Appointment Resource
Route::get('/fhir/Appointment/{id}', [FHIRController::class, 'getAppointment']);
Route::get('/fhir/Appointment', [FHIRController::class, 'getAllAppointments']);

// FHIR Condition Resource (Diagnosis)
Route::get('/fhir/Condition/{id}', [FHIRController::class, 'getCondition']);
Route::get('/fhir/Condition', [FHIRController::class, 'getAllConditions']);

// FHIR Procedure Resource (Tindakan)
Route::get('/fhir/Procedure/{id}', [FHIRController::class, 'getProcedure']);
Route::get('/fhir/Procedure', [FHIRController::class, 'getAllProcedures']);
