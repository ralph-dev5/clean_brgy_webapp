<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;

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

    // Admin dashboard
    Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

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
        Route::get('/profile', [AdminController::class, 'profile'])
            ->name('profile');

        // Admin history
        Route::get('/history', [AdminController::class, 'history'])
            ->name('history');

        // -------------------------
        // Admin Report Management
        // -------------------------
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index');
            Route::get('/{report}', [ReportController::class, 'show'])->name('show');
            Route::get('/{report}/edit', [ReportController::class, 'edit'])->name('edit');
            Route::put('/{report}', [ReportController::class, 'update'])->name('update');
            Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
        });

    });

});
