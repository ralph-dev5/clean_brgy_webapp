<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Show the report creation form for users.
     */
    public function create()
    {
        return view('report.create');
    }

    /**
     * Store a new user report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('reports', 'public');
        }

        Report::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'pending', // Default status
        ]);

        return redirect()->route('dashboard')->with('success', 'Report submitted successfully.');
    }

    /**
     * User: Delete a report (only their own reports).
     */
    public function destroy(Report $report)
    {
        if ($report->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return redirect()->route('user.dashboard')->with('success', 'Report deleted successfully.');
    }

    /**
     * Admin: Show list of all reports.
     */
    public function index()
    {
        $reports = Report::with('user')->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }

    /**
     * Admin: Show single report details.
     */
    public function show(Report $report)
    {
        $report->load('user');
        return view('admin.reports.show', compact('report'));
    }

    /**
     * Admin: Show edit form for a report.
     */
    public function edit(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    /**
     * Admin: Update a report.
     */
    public function update(Request $request, Report $report)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($report->image) {
                Storage::disk('public')->delete($report->image);
            }
            $report->image = $request->file('image')->store('reports', 'public');
        }

        $report->update([
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.reports.index')->with('success', 'Report updated successfully.');
    }
}
