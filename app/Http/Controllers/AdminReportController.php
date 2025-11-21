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
     * Update only the report status (Pending → In Progress → Resolved).
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
     * Soft delete — move report to Trash.
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('admin.reports.index')
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
