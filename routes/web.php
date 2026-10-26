<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/ortak', [DashboardController::class, 'ortak'])->name('dashboard.ortak');

    // Planlama Merkezi
    Route::get('/planlama', [ScheduleController::class, 'index'])->name('planlama.index');
    Route::post('/planlama/ders-ekle', [ScheduleController::class, 'storeCourse'])->name('planlama.course.store');
    Route::post('/planlama/sinif-ekle', [ScheduleController::class, 'storeClassroom'])->name('planlama.classroom.store');
    
    // Program İşlemleri
    Route::post('/planlama/program-kaydet', [ScheduleController::class, 'storeSchedule'])->name('planlama.schedule.store');
    Route::put('/planlama/program-guncelle/{schedule}', [ScheduleController::class, 'updateSchedule'])->name('planlama.schedule.update');
    Route::delete('/planlama/program-sil/{schedule}', [ScheduleController::class, 'destroySchedule'])->name('planlama.schedule.destroy');
    
    // YENİ: Toplu Silme Rotası
    Route::delete('/planlama/program-toplu-sil', [ScheduleController::class, 'truncateSchedules'])->name('planlama.schedule.truncate');

    // PDF Yükleme
    Route::post('/planlama/pdf-yukle', [ScheduleController::class, 'uploadPdf'])->name('planlama.pdf.upload');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';