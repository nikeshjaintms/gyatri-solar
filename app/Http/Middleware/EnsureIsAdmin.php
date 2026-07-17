<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if (in_array($user->role, ['Employee', 'Technician'])) {
                return redirect()->route('employee.attendance')->with('error', 'Unauthorized access to Admin section.');
            }
        }

        return $next($request);
    }
}
