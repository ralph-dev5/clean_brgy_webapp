<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminDashboardController extends Controller
{
    /**
     * Show admin dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Fetch all reports for admin
        $reports = Report::with('user')->latest()->get();

        return view('dashboard.admin', compact('user', 'reports'));
    }
}

