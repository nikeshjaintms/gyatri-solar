<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsEmployee
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user->role, ['Super Admin', 'Admin', 'Manager'])) {
                return redirect()->route('dashboard')->with('error', 'Admins are redirected to the admin dashboard.');
            }
        }

        return $next($request);
    }
}
