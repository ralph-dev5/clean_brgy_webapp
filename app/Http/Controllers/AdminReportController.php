<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class AdminReportController extends Controller
{
    /**
     * Display reports filtered by status (Pending, In-Progress, Resolved)
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $allowedStatuses = ['pending', 'in-progress', 'resolved'];
        if (!in_array($status, $allowedStatuses)) {
            $status = 'pending';
        }

        $reports = Report::with('user')
            ->where('status', $status)
            ->latest()
            ->get();

        return view('admin.reports.index', compact('reports', 'status'));
    }

    /**
     * Show report details
     */
    public function show(Report $report)
    {
        $report->load('user');
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Edit report view (optional)
     */
    public function edit(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Update report info
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'description' => 'required|string',
            'location'    => 'nullable|string',
            'status'      => 'required|in:pending,in-progress,resolved',
        ]);

        $report->update($request->only(['description', 'location', 'status']));

        return redirect()
            ->route('admin.reports.index', ['status' => $report->status])
            ->with('success', 'Report updated successfully.');
    }

    /**
     * Delete a report
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()
            ->route('admin.reports.index')
            ->with('success', 'Report deleted successfully.');
    }

    /**
     * Update report status ("Done" button)
     * Pending → In-Progress → Resolved
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,resolved',
        ]);

        $report->status = $request->status;
        $report->save();

        return redirect()
            ->route('admin.reports.index', ['status' => $request->status])
            ->with('success', "Report status updated to {$request->status}.");
    }

    /**
     * Show history (all resolved reports)
     */
    public function history()
    {
        $reports = Report::where('status', 'resolved')
            ->latest()
            ->get();

        return view('admin.history', compact('reports'));
    }
}
