<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class ReportAdminController extends Controller
{
    // Display a list of all reports
    public function index()
    {
        // Get all reports, latest first
        $reports = Report::with('user')->latest()->get();

        return view('dashboard.admin', compact('reports'));
    }

    // Display a single report
    public function show($id)
    {
        $report = Report::with('user')->findOrFail($id);

        return view('dashboard.admin-show', compact('report'));
    }
}
