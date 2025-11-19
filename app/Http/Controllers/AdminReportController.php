<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    /**
     * Display a list of reports filtered by status.
     */
    public function index(Request $request)
    {
        // Get the requested status or default to 'pending'
        $status = $request->get('status', 'pending');

        // Validate status
        $allowedStatuses = ['pending', 'in-progress', 'resolved'];
        if (!in_array($status, $allowedStatuses)) {
            $status = 'pending';
        }

        // Fetch reports with the selected status
        $reports = Report::with('user')
            ->where('status', $status)
            ->latest()
            ->get();

        return view('admin.reports.index', compact('reports', 'status'));
    }
}
