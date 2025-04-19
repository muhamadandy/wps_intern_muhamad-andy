<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Routes for guest (belum login)
Route::view('/', 'auth.login')->middleware('guest')->name('login');
Route::post('/', [AuthController::class, 'login']);

// Routes that require authentication (sudah login)
Route::middleware(['auth'])->group(function () {

    // Logout Route
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Log routes
    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    Route::get('/logs/create', [LogController::class,'create'])->name('logs.create');
    Route::get('/logs/{log}', [LogController::class, 'show'])->name('logs.show');
    Route::put('/logs/{log}', [LogController::class, 'update'])->name('logs.update');
    Route::get('/logs/{log}/edit', [LogController::class, 'edit'])->name('logs.edit');
    Route::post('/logs', [LogController::class, 'store'])->name('logs.store');
    Route::delete('/logs/{log}', [LogController::class, 'destroy'])->name('logs.destroy');
    Route::get('/logs/{log}/download', [LogController::class, 'download'])->name('logs.download');

    Route::get('/calendar/logs', [CalendarController::class, 'getLogsForCalendar'])->name('calendar.logs');

    Route::get('/verifikasi-log', [LogController::class, 'verifikasiLog'])->name('verifikasi-log');

    Route::put('/logs/{log}/approve', [LogController::class, 'approved'])->name('logs.approve');

    Route::put('/logs/{log}/reject', [LogController::class, 'rejected'])->name('logs.reject');

    Route::post('/notifications/{id}/read', function ($id) {
        $notification = Auth::user()->notifications->findOrFail($id);
        $notification->markAsRead();
        return back();
    })->name('notifications.markAsRead');

});
