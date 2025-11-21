<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $report = new Report();
        $report->user_id = Auth::id();
        $report->type = $request->type;
        $report->description = $request->description;
        $report->status = 'pending';

        // Handle image upload
        if ($request->hasFile('image')) {
            $report->image = $request->file('image')->store('reports', 'public');
        }

        $report->save();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Report submitted successfully!');
    }

    /**
     * Delete a report.
     */
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        // Only allow owner to delete
        if ($report->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Delete image if exists
        if ($report->image && Storage::disk('public')->exists($report->image)) {
            Storage::disk('public')->delete($report->image);
        }

        $report->delete();

        return redirect()
            ->back()
            ->with('success', 'Report deleted successfully!');
    }
}
