<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get selected status from URL (?status=)
        $status = $request->get('status', 'pending'); 
        // default to pending if none is selected

        // Fetch reports with status filtering
        $reports = Report::with('user')
            ->where('status', $status)
            ->latest()
            ->get();

        return view('dashboard.admin', compact('user', 'reports', 'status'));
    }
}
