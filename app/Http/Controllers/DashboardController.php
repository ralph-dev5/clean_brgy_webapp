<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // User Dashboard (default dashboard)
    public function index()
    {
        $reports = Report::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('dashboard.user', compact('reports'));
    }

    // Admin Dashboard: show all reports
    public function admin()
    {
        $reports = Report::with('user')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('dashboard.admin', compact('reports'));
    }

    // User dashboard (alias - optional)
    public function user()
    {
        $reports = Report::where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('dashboard.user', compact('reports'));
    }
}
