<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the logged-in user's dashboard.
     */
    public function user()
    {
        $user = auth()->user();

        // whatever data you are passing already:
        return view('dashboard.user', [
            'user' => $user,
            'reports' => $user->reports()->latest()->paginate(10),
            'totalReports' => $user->reports()->count(),
            'pendingReports' => $user->reports()->where('status', 'pending')->count(),
            'inProgressReports' => $user->reports()->where('status', 'in-progress')->count(),
            'resolvedReports' => $user->reports()->where('status', 'resolved')->count(),
            'submittedImages' => $user->reports()->whereNotNull('image')->count(),
        ]);
    }


    /**
     * Show the logged-in user's trash (deleted reports).
     */
    public function trash()
    {
        $user = Auth::user();

        $trashedReports = Report::onlyTrashed()
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.user.trash', compact('user', 'trashedReports'));
    }

    /**
     * Show the admin dashboard.
     */
    public function admin()
    {
        $admin = Auth::user();

        $totalUsers = User::count();
        $totalReports = Report::count();
        $pendingReports = Report::where('status', 'pending')->count();
        $inProgressReports = Report::where('status', 'in-progress')->count();
        $resolvedReports = Report::where('status', 'resolved')->count();

        return view('dashboard.admin.dashboard', compact(
            'admin',
            'totalUsers',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports'
        ));
    }
}
