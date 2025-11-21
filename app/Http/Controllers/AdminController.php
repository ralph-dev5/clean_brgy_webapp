<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard with stats and recent reports.
     */
    public function dashboard()
    {
        $admin = Auth::user();

        // Dashboard statistics
        $totalUsers        = User::count();
        $totalReports      = Report::count();
        $pendingReports    = Report::where('status', 'pending')->count();
        $inProgressReports = Report::where('status', 'in-progress')->count();
        $resolvedReports   = Report::where('status', 'resolved')->count();

        // Latest 10 reports with associated user
        $recentReports = Report::with('user')->latest()->take(10)->get();

        // Pass all data to the admin dashboard view
        // Updated view path to match resources/views/admin/dashboard.blade.php
        return view('admin.dashboard', [
            'admin'             => $admin,
            'totalUsers'        => $totalUsers,
            'totalReports'      => $totalReports,
            'pendingReports'    => $pendingReports,
            'inProgressReports' => $inProgressReports,
            'resolvedReports'   => $resolvedReports,
            'recentReports'     => $recentReports,
        ]);
    }
}
