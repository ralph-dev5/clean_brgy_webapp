<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminReportController;

// -------------------------------------
// Homepage
// -------------------------------------
Route::get('/', function () {
    return view('welcome');
});

// -------------------------------------
// Authentication Routes
// -------------------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// -------------------------------------
// Authenticated Routes
// -------------------------------------
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // ---------------------------------
    // Dashboard Routes
    // ---------------------------------
    Route::get('/dashboard/user', [DashboardController::class, 'user'])->name('user.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Auto-redirect based on role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // ---------------------------------
    // User Report Routes
    // ---------------------------------
    Route::prefix('report')->name('report.')->group(function () {
        Route::get('/create', [ReportController::class, 'create'])->name('create');
        Route::post('/', [ReportController::class, 'store'])->name('store');
        Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy'); // DELETE for user dashboard
    });

    // ---------------------------------
    // Admin Routes
    // ---------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {

        // Admin Profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

        // Admin History (Resolved Reports)
        Route::get('/history', [AdminReportController::class, 'history'])->name('history');

        // Admin Reports Management
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AdminReportController::class, 'index'])->name('index');      // List all reports
            Route::get('/{report}', [AdminReportController::class, 'show'])->name('show'); // View single report
            Route::get('/{report}/edit', [AdminReportController::class, 'edit'])->name('edit'); // Edit report
            Route::put('/{report}', [AdminReportController::class, 'update'])->name('update'); // Update report
            Route::delete('/{report}', [AdminReportController::class, 'destroy'])->name('destroy'); // Delete report
            Route::patch('/{report}/status', [AdminReportController::class, 'updateStatus'])->name('updateStatus'); // Update status
        });

    });
});
