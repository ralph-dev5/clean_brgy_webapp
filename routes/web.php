<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

/* // Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');
 */

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard/user', [DashboardController::class, 'index'])->name('user.dashboard');
});


/* // USER DASHBOARD
Route::get('/dashboard/user', [DashboardController::class, 'user'])
    ->name('user.dashboard')
    ->middleware('auth');
 */
Route::middleware('auth')->group(function () {
    Route::get('/dashboard/user', [DashboardController::class, 'index'])->name('user.dashboard');
});


// ADMIN DASHBOARD
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])
    ->name('admin.dashboard')
    ->middleware('auth');

// GENERIC DASHBOARD (redirect by role)
Route::get('/dashboard', function () {
    if (auth()->check()) {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard')->middleware('auth');

// REPORT ROUTES
Route::get('/report/create', [ReportController::class, 'create'])->name('report.create')->middleware('auth');
Route::post('/report', [ReportController::class, 'store'])->name('report.store')->middleware('auth');

// Admin: View all reports
Route::get('/admin/reports', [ReportController::class, 'index'])
    ->name('admin.reports.index')
    ->middleware('auth');

// Admin: View a single report
Route::get('/admin/reports/{report}', [ReportController::class, 'show'])
    ->name('admin.reports.show')
    ->middleware('auth');
