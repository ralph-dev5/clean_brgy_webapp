<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Fetch all reports for admin
        $reports = Report::with('user')->latest()->get();

        return view('dashboard.admin', compact('user', 'reports'));
    }

    /**
     * Show the admin profile page.
     */
    public function profile()
    {
        $user = auth()->user();
        return view('dashboard.profile', compact('user'));
    }

    /**
     * Show the admin history page.
     */
    public function history()
    {
        $user = auth()->user();

        // Example: Fetch reports created by the admin
        $reports = Report::where('user_id', $user->id)->latest()->get();

        return view('dashboard.history', compact('user', 'reports'));
    }
}
