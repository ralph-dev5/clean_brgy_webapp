<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Admin Dashboard – statistics + recent reports
     */
    public function dashboard()
    {
        $admin = Auth::user();

        $totalUsers        = User::count();
        $totalReports      = Report::count();
        $pendingReports    = Report::where('status', 'pending')->count();
        $inProgressReports = Report::where('status', 'in-progress')->count();
        $resolvedReports   = Report::where('status', 'resolved')->count();

        $recentReports = Report::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'admin',
            'totalUsers',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'recentReports'
        ));
    }

    /**
     * List all users
     */
    public function users()
    {
        $users = User::all();
        $totalUsers = $users->count();

        return view('admin.users', compact('users', 'totalUsers'));
    }

    /**
     * Analytics Page
     */
    public function analytics()
    {
        $admin = Auth::user();

        $totalUsers        = User::count();
        $totalReports      = Report::count();
        $pendingReports    = Report::where('status', 'pending')->count();
        $inProgressReports = Report::where('status', 'in-progress')->count();
        $resolvedReports   = Report::where('status', 'resolved')->count();

        $topUsers = User::withCount('reports')->orderByDesc('reports_count')->take(10)->get();

        return view('admin.analytics', compact(
            'admin',
            'totalUsers',
            'totalReports',
            'pendingReports',
            'inProgressReports',
            'resolvedReports',
            'topUsers'
        ));
    }

    /**
     * Admin Settings Page
     */
    public function settings()
    {
        $admin = Auth::user();

        $preferences = [
            'site_name'     => config('app.name', 'My Website'),
            'admin_email'   => $admin->email,
            'notifications' => true,
        ];

        return view('admin.settings', compact('admin', 'preferences'));
    }

    /**
     * Update Admin Password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        $admin = Auth::user();
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.settings')->with('success', 'Password updated successfully.');
    }

    /**
     * Update Site Preferences
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'site_name'     => 'required|string|max:255',
            'admin_email'   => 'required|email|max:255',
            'notifications' => 'nullable|boolean',
        ]);

        return redirect()->route('admin.settings')->with('success', 'Preferences updated successfully.');
    }

    /**
     * Admin Profile Page
     */
    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    /**
     * Edit Profile Form
     */
    public function editProfile()
    {
        $admin = Auth::user();
        return view('admin.edit-profile', compact('admin'));
    }

    /**
     * Save Admin Profile Updates + Avatar Upload
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::user();

        $request->validate([
            'name'   => 'sometimes|required|string|max:255',
            'email'  => 'sometimes|required|email|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($admin->avatar && Storage::disk('public')->exists($admin->avatar)) {
                Storage::disk('public')->delete($admin->avatar);
            }

            // Store new avatar in a dedicated admin folder
            $admin->avatar = $request->file('avatar')->store('avatars/admin', 'public');
        }

        // Update name & email
        if ($request->filled('name')) {
            $admin->name = $request->name;
        }

        if ($request->filled('email')) {
            $admin->email = $request->email;
        }
        $admin->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
