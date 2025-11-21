<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;

// ---------------------------------------------
// Public Homepage
// ---------------------------------------------
Route::get('/', fn() => view('welcome'))->name('home');

// ---------------------------------------------
// Authentication
// ---------------------------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// ---------------------------------------------
// Authenticated Routes
// ---------------------------------------------
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Auto redirect based on role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');

    // ---------------------------------------------
    // USER ROUTES
    // ---------------------------------------------
    Route::middleware('user')
        ->prefix('dashboard/user')
        ->name('user.')
        ->group(function () {
            // Main dashboard
            Route::get('/', [DashboardController::class, 'user'])->name('dashboard');

            // User Reports
            Route::prefix('report')->name('report.')->group(function () {
                Route::get('/create', [ReportController::class, 'create'])->name('create');
                Route::post('/', [ReportController::class, 'store'])->name('store');
                Route::delete('/{id}', [ReportController::class, 'destroy'])->name('destroy');
            });
        });

    // ---------------------------------------------
    // ADMIN ROUTES
    // ---------------------------------------------
    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            // Profile
            Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
            Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
            Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

            // History
            Route::get('/history', [AdminReportController::class, 'history'])->name('history');

            // Reports CRUD
            Route::prefix('reports')->name('reports.')->group(function () {
                Route::get('/trash', [AdminReportController::class, 'trash'])->name('trash');
                Route::patch('/{report}/restore', [AdminReportController::class, 'restore'])->name('restore');
                Route::delete('/{report}/force-delete', [AdminReportController::class, 'forceDelete'])->name('forceDelete');
                Route::patch('/{report}/status', [AdminReportController::class, 'updateStatus'])->name('updateStatus');

                Route::get('/', [AdminReportController::class, 'index'])->name('index');
                Route::get('/{report}', [AdminReportController::class, 'show'])->name('show');
                Route::get('/{report}/edit', [AdminReportController::class, 'edit'])->name('edit');
                Route::put('/{report}', [AdminReportController::class, 'update'])->name('update');
                Route::delete('/{report}', [AdminReportController::class, 'destroy'])->name('destroy');
            });
        });
});
