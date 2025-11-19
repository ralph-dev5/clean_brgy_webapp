<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminDashboardController;
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

    // -----------------------------
    // DASHBOARD ROUTES
    // -----------------------------
    // User dashboard
    Route::get('/dashboard/user', [DashboardController::class, 'user'])
        ->name('user.dashboard');

    // Admin dashboard (AdminController version)
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Optional: AdminDashboardController version (can remove if you use AdminController)
    // Route::get('/dashboard/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Auto-redirect based on role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // -----------------------------
    // REPORTS (USER)
    // -----------------------------
    Route::get('/report/create', [ReportController::class, 'create'])
        ->name('report.create');

    Route::post('/report', [ReportController::class, 'store'])
        ->name('report.store');

    // -----------------------------
    // ADMIN PAGES
    // -----------------------------
    Route::prefix('admin')->name('admin.')->group(function () {

        // Admin profile
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');

        // Admin history
        Route::get('/history', [AdminController::class, 'history'])->name('history');

        // Admin reports overview page
        Route::get('/reports', [AdminDashboardController::class, 'index'])->name('reports');

        // Admin Report Management
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [AdminReportController::class, 'index'])->name('index');            // List reports
            Route::get('/{report}', [AdminReportController::class, 'show'])->name('show');      // View single report
            Route::get('/{report}/edit', [AdminReportController::class, 'edit'])->name('edit'); // Edit report
            Route::put('/{report}', [AdminReportController::class, 'update'])->name('update');  // Update report
            Route::delete('/{report}', [AdminReportController::class, 'destroy'])->name('destroy'); // Delete report
        });

    });

});
