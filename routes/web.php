<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;

/*
|--------------------------------------------------------------------------
| Public Homepage
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('home');


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Redirect based on role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('user.dashboard');
    })->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | USER ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('user')
        ->prefix('dashboard/user')
        ->name('user.')
        ->group(function () {

            // User Dashboard
            Route::get('/', [DashboardController::class, 'user'])->name('dashboard');

            /*
            |-----------------------------
            | Reports CRUD
            |-----------------------------
            */
            Route::prefix('report')->name('report.')->group(function () {
                Route::get('/create', [ReportController::class, 'create'])->name('create');
                Route::post('/', [ReportController::class, 'store'])->name('store');
                Route::get('/{report}', [ReportController::class, 'show'])->name('show');
                Route::delete('/{report}', [ReportController::class, 'destroy'])->name('destroy');
            });

            /*
            |-----------------------------
            | Profile Management
            |-----------------------------
            */
            Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
            Route::put('/profile/update', [DashboardController::class, 'updateProfile'])->name('profile.update');
            Route::put('/profile/password', [DashboardController::class, 'updatePassword'])->name('profile.password');
            Route::put('/profile/picture', [DashboardController::class, 'updateProfilePicture'])->name('profile.picture');
        });


    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // Dashboard
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            /*
            |-----------------------------
            | Profile Management
            |-----------------------------
            */
            Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
            Route::get('/profile/edit', [AdminController::class, 'editProfile'])->name('profile.edit');
            Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');
            Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('profile.password');

            /*
            |-----------------------------
            | Settings / Preferences
            |-----------------------------
            */
            Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
            Route::put('/settings/preferences', [AdminController::class, 'updatePreferences'])->name('settings.updatePreferences');

            /*
            |-----------------------------
            | Reports History
            |-----------------------------
            */
            Route::get('/history', [AdminReportController::class, 'history'])->name('history');

            /*
            |-----------------------------
            | Reports Management
            |-----------------------------
            */
            Route::prefix('reports')->name('reports.')->group(function () {

                // Trash & Restore
                Route::get('/trash', [AdminReportController::class, 'trash'])->name('trash');
                Route::patch('/{report}/restore', [AdminReportController::class, 'restore'])->name('restore');
                Route::delete('/{report}/force-delete', [AdminReportController::class, 'forceDelete'])->name('forceDelete');

                // Status Changes
                Route::patch('/{report}/status', [AdminReportController::class, 'updateStatus'])->name('updateStatus');
                Route::patch('/{report}/resolve', [AdminReportController::class, 'resolve'])->name('resolve');
                Route::patch('/{report}/advance', [AdminReportController::class, 'advanceStatus'])->name('advanceStatus');

                // CRUD
                Route::get('/', [AdminReportController::class, 'index'])->name('index');
                Route::get('/{report}', [AdminReportController::class, 'show'])->name('show');
                Route::get('/{report}/edit', [AdminReportController::class, 'edit'])->name('edit');
                Route::put('/{report}', [AdminReportController::class, 'update'])->name('update');
                Route::delete('/{report}', [AdminReportController::class, 'destroy'])->name('destroy');
            });

            // Users List & Analytics
            Route::get('/users', [AdminController::class, 'users'])->name('users');
            Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
        });
});
