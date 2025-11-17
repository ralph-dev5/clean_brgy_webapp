<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    // Show the report form for users
    public function create()
    {
        return view('report.create');
    }

    // Store a new report
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
        ]);

        return redirect()->route('dashboard')->with('success', 'Report sent to admin.');
    }

    // Admin: List all reports
    public function index()
    {
        $reports = Report::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.reports.index', compact('reports'));
    }

    // Admin: Show single report
    public function show(Report $report)
    {
        return view('admin.reports.show', compact('report'));
    }

    // Admin: Edit report
    public function edit(Report $report)
    {
        return view('admin.reports.edit', compact('report'));
    }

    // Admin: Update report
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

        $report->type = $request->type;
        $report->description = $request->description;
        $report->save();

        return redirect()->route('admin.reports.index')->with('success', 'Report updated successfully.');
    }

    // Admin: Delete report
    public function destroy(Report $report)
    {
        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }
        $report->delete();

        return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully.');
    }
}
