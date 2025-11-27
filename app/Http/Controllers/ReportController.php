<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Show the form to create a new report.
     */
    public function create()
    {
        return view('report.create');
    }

    /**
     * Store a new report.
     */
    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // 2MB max
        ]);

        $report = new Report();
        $report->user_id = Auth::id();
        $report->location = $request->location;
        $report->description = $request->description;
        $report->status = 'pending';

        // Handle uploaded report image
        if ($request->hasFile('image')) {
            $report->image = $request->file('image')->store('reports', 'public');
        }

        $report->save();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Report submitted successfully!');
    }

    /**
     * Show a specific report (for the VIEW functionality).
     */
    public function show($id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('report.show', compact('report'));
    }

    /**
     * Delete a report along with its image from storage.
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete report image if exists
        if ($report->image && Storage::disk('public')->exists($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return redirect()
            ->back()
            ->with('success', 'Report deleted successfully!');
    }

    /**
     * Optional: Update the report's image (new feature)
     */
    public function updateImage(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        // Delete old image if exists
        if ($report->image && Storage::disk('public')->exists($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        // Store new image
        $report->image = $request->file('image')->store('reports', 'public');
        $report->save();

        return redirect()
            ->back()
            ->with('success', 'Report image updated successfully!');
    }
}
