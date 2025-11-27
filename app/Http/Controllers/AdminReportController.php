<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    /**
     * Display all reports, grouped by status.
     */
    public function index()
    {
        $pendingReports = Report::with('user')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $inProgressReports = Report::with('user')
            ->where('status', 'in-progress')
            ->latest()
            ->get();

        $resolvedReports = Report::with('user')
            ->where('status', 'resolved')
            ->latest()
            ->get();

        return view('admin.reports.index', compact(
            'pendingReports',
            'inProgressReports',
            'resolvedReports'
        ));
    }

    /**
     * Show a single report.
     */
    public function show(Report $report)
    {
        $report->load('user');

        return view('admin.reports.show', compact('report'));
    }

    /**
     * Show the edit form for a report.
     */
    public function edit(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Update report fields.
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pending,in-progress,resolved',
        ]);

        $report->update($request->only('type', 'description', 'status'));

        return redirect()->route('admin.reports.index')
                         ->with('success', 'Report updated successfully.');
    }

    /**
     * Update only the report status manually.
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,resolved',
        ]);

        $report->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Report status updated successfully!');
    }

    /**
     * Advance the report to the next status: Pending → In Progress → Resolved.
     * This replaces the old "resolve" method for the check button functionality.
     */
    public function advanceStatus(Request $request, Report $report)
    {
        switch ($report->status) {
            case 'pending':
                $report->update(['status' => 'in-progress']);
                break;
            case 'in-progress':
                $report->update(['status' => 'resolved']);
                break;
            case 'resolved':
                if ($request->wantsJson()) {
                    return response()->json([
                        'new_status' => $report->status,
                        'message' => 'Report is already resolved.'
                    ], 200);
                }

                return redirect()->back()->with('info', 'Report is already resolved.');
        }

        if ($request->wantsJson()) {
            return response()->json([
                'new_status' => $report->status,
                'message' => 'Report status advanced successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Report status advanced successfully!');
    }

    /**
     * Soft delete — move report to Trash.
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Report moved to Trash.');
    }

    /**
     * Display soft-deleted reports (Trash).
     */
    public function trash()
    {
        $reports = Report::onlyTrashed()
            ->with('user')
            ->latest('deleted_at')
            ->get();

        return view('admin.reports.trash', compact('reports'));
    }

    /**
     * Restore a report from Trash.
     */
    public function restore(int $id)
    {
        $report = Report::onlyTrashed()->find($id);

        if (!$report) {
            return redirect()->back()->with('error', 'Report not found.');
        }

        $report->restore();

        return redirect()->route('admin.reports.trash')
                         ->with('success', 'Report restored successfully.');
    }

    /**
     * Permanently delete a report from Trash.
     */
    public function forceDelete(int $id)
    {
        $report = Report::onlyTrashed()->find($id);

        if (!$report) {
            return redirect()->back()->with('error', 'Report not found.');
        }

        $report->forceDelete();

        return redirect()->route('admin.reports.trash')
                         ->with('success', 'Report permanently deleted.');
    }
}
