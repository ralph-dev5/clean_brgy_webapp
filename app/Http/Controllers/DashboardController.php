<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Show the logged-in user's dashboard.
     */
    public function user()
    {
        $user = Auth::user();

        // Determine if this is the user's first login
        $isFirstLogin = !$user->first_login_done;

        // Mark first login as done
        if ($isFirstLogin) {
            $user->first_login_done = true;
            $user->save();
        }

        return view('dashboard.user', [
            'user' => $user,
            'isFirstLogin' => $isFirstLogin,
            'reports' => $user->reports()->latest()->paginate(10),
            'totalReports' => $user->reports()->count(),
            'pendingReports' => $user->reports()->where('status', 'pending')->count(),
            'inProgressReports' => $user->reports()->where('status', 'in-progress')->count(),
            'resolvedReports' => $user->reports()->where('status', 'resolved')->count(),
            'submittedImages' => $user->reports()->whereNotNull('image')->count(),
        ]);
    }

    /**
     * Show the user's soft-deleted reports.
     */
    public function trash()
    {
        $user = Auth::user();

        $trashedReports = Report::onlyTrashed()
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.user.trash', compact('user', 'trashedReports'));
    }

    /**
     * Show the admin dashboard.
     */
    public function admin()
    {
        $admin = Auth::user();

        return view('dashboard.admin.dashboard', [
            'admin' => $admin,
            'totalUsers' => User::count(),
            'totalReports' => Report::count(),
            'pendingReports' => Report::where('status', 'pending')->count(),
            'inProgressReports' => Report::where('status', 'in-progress')->count(),
            'resolvedReports' => Report::where('status', 'resolved')->count(),
        ]);
    }

    /**
     * Show logged-in user's profile page.
     */
    public function profile()
    {
        return view('dashboard.user.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update logged-in user's profile (name, email, avatar).
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'avatar' => 'nullable|image|max:2048',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()
            ->route('user.dashboard')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Update logged-in user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()
            ->route('user.profile')
            ->with('success', 'Password changed successfully!');
    }
}
