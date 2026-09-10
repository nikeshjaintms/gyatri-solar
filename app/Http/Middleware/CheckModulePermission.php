<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckModulePermission
{
    /**
     * Handle an incoming request and check permissions based on HTTP verb / route action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $module  e.g. 'customers', 'quotations', 'site_surveys', 'job_assignments'
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $module): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Super Admin & Admin have full implicit access
        if ($user->role === 'Super Admin' || $user->hasRole('Super Admin') || $user->role === 'Admin' || $user->hasRole('Admin')) {
            return $next($request);
        }

        $action = $this->determineAction($request);
        $requiredPermission = "{$action}_{$module}";

        // Special fallback: for view actions, check if user has view_ OR any permission in this module
        if ($action === 'view') {
            $hasPermission = $user->can($requiredPermission) ||
                $user->can("create_{$module}") ||
                $user->can("update_{$module}") ||
                $user->can("delete_{$module}");
        } else {
            $hasPermission = $user->can($requiredPermission);
        }

        if (!$hasPermission) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "Unauthorized. You do not have permission to {$action} this module ({$module}).",
                ], 403);
            }

            return redirect()->route('dashboard')->with('error', "Access Denied: You do not have permission to access {$module}.");
        }

        return $next($request);
    }

    /**
     * Determine the CRUD action based on route or request method.
     */
    protected function determineAction(Request $request): string
    {
        $routeAction = $request->route() ? $request->route()->getActionMethod() : '';

        switch ($routeAction) {
            case 'create':
            case 'store':
                return 'create';

            case 'edit':
            case 'update':
            case 'toggleStatus':
                return 'update';

            case 'destroy':
                return 'delete';

            case 'print':
                return 'view';

            case 'index':
            case 'show':
            default:
                $method = $request->method();
                if ($method === 'POST') return 'create';
                if (in_array($method, ['PUT', 'PATCH'])) return 'update';
                if ($method === 'DELETE') return 'delete';
                return 'view';
        }
    }
}
