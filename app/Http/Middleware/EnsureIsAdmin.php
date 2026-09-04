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
            // Technicians only access the technician attendance portal
            if ($user->role === 'Technician') {
                return redirect()->route('employee.attendance')->with('error', 'Unauthorized access.');
            }
        }

        return $next($request);
    }
}
