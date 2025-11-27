<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Only allows users with the "user" role to proceed.
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if user is authenticated and has the 'user' role
        if (Auth::check() && Auth::user()->role === 'user') {
            return $next($request);
        }

        // If not, redirect to login with an error message
        return redirect()->route('login')->with('error', 'You do not have access to this page.');
    }
}
